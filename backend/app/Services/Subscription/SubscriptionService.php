<?php

namespace App\Services\Subscription;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Subscription;
use App\Contracts\MikrotikServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\Subscription\ActivateSubscriptionAction;
use App\Actions\Subscription\SuspendSubscriptionAction;
use App\Actions\Subscription\ExpireSubscriptionAction;
use App\Actions\Subscription\RestoreSubscriptionAction;
use App\Actions\Subscription\RenewSubscriptionAction;

class SubscriptionService
{
    protected ActivateSubscriptionAction $activateAction;
    protected SuspendSubscriptionAction $suspendAction;
    protected ExpireSubscriptionAction $expireAction;
    protected RestoreSubscriptionAction $restoreAction;
    protected RenewSubscriptionAction $renewAction;

    protected SubscriptionRepositoryInterface $subscriptionRepository;
    protected MikrotikServiceInterface $mikrotikService;

    /**
     * حقن التبعيات عبر الـ Constructor
     */
    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        MikrotikServiceInterface $mikrotikService,

        ActivateSubscriptionAction $activateAction,
        SuspendSubscriptionAction $suspendAction,
        ExpireSubscriptionAction $expireAction,
        RestoreSubscriptionAction $restoreAction,
        RenewSubscriptionAction $renewAction,
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->mikrotikService = $mikrotikService;

        $this->activateAction = $activateAction;
        $this->suspendAction = $suspendAction;
        $this->expireAction = $expireAction;
        $this->restoreAction = $restoreAction;
        $this->renewAction = $renewAction;
    }

    /**
     * الحصول على جميع الاشتراكات مع الفلاتر
     */
    public function getAllSubscriptions(array $filters = [], int $perPage = 15)
    {
        return $this->subscriptionRepository->getAll($filters, $perPage);
    }

    /**
     * الحصول على اشتراك بواسطة ID
     */
    public function getSubscriptionById(int $id): ?Subscription
    {
        return $this->subscriptionRepository->findById($id);
    }

    /**
     * الحصول على اشتراكات عميل معين
     */
    public function getCustomerSubscriptions(int $customerId): array
    {
        return $this->subscriptionRepository->getByCustomerId($customerId);
    }

    /**
     * الحصول على الاشتراكات النشطة
     */
    public function getActiveSubscriptions(): array
    {
        return $this->subscriptionRepository->getActiveSubscriptions();
    }

    /**
     * الحصول على الاشتراكات المنتهية
     */
    public function getExpiredSubscriptions(): array
    {
        return $this->subscriptionRepository->getExpiredSubscriptions();
    }

    /**
     * إنشاء اشتراك جديد
     */
    public function createSubscription(array $data): Subscription
    {
        return DB::transaction(function () use ($data) {
            // التحقق من وجود العميل والباقة
            $customer = Customer::findOrFail($data['customer_id']);
            $package = Package::findOrFail($data['package_id']);

            // حساب المدة والسعر
            $durationMonths = $data['duration_months'] ?? $package->duration_months;
            $price = $data['price'] ?? $package->price;
            $discount = $data['discount'] ?? 0;

            // تاريخ الانتهاء
            $startDate = now();
            $expiryDate = $startDate->copy()->addMonths($durationMonths);

            // إنشاء الاشتراك
            $subscription = $this->subscriptionRepository->create([
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'start_date' => $startDate,
                'expiry_date' => $expiryDate,
                'status' => 'active',
                'price' => $price,
                'discount' => $discount,
                'total' => $price - $discount,
                'duration_months' => $durationMonths,
                'notes' => $data['notes'] ?? null,
            ]);

            // تحديث بيانات العميل
            $customer->update([
                'package_id' => $package->id,
                'status' => 'active',
                'expiry_date' => $expiryDate,
            ]);

            // إنشاء مستخدم MikroTik إذا كانت الباقة متصلة بـ MikroTik
            if ($package->mikrotik_profile) {
                $this->createMikrotikUser($customer, $package, $subscription);
            }

            // تسجيل النشاط
            Log::info("تم إنشاء اشتراك جديد للعميل: {$customer->name}", [
                'subscription_id' => $subscription->id,
                'package' => $package->name,
            ]);

            return $subscription;
        });
    }

    /**
     * تحديث اشتراك
     */
    public function updateSubscription(int $id, array $data): Subscription
    {
        return DB::transaction(function () use ($id, $data) {
            $subscription = $this->subscriptionRepository->findById($id);

            if (!$subscription) {
                throw new \Exception('الاشتراك غير موجود');
            }

            // تحديث الاشتراك
            $updated = $this->subscriptionRepository->update($id, $data);

            // إذا تم تغيير الباقة
            if (isset($data['package_id']) && $data['package_id'] != $subscription->package_id) {
                $newPackage = Package::find($data['package_id']);
                if ($newPackage) {
                    // تحديث العميل
                    Customer::where('id', $subscription->customer_id)->update([
                        'package_id' => $newPackage->id,
                    ]);

                    // تحديث MikroTik
                    $customer = Customer::find($subscription->customer_id);
                    if ($customer && $newPackage->mikrotik_profile) {
                        $this->updateMikrotikUser($customer, $newPackage);
                    }
                }
            }

            Log::info("تم تحديث الاشتراك: {$subscription->id}");
            return $updated;
        });
    }

    /**
     * تجديد اشتراك
     */
    public function renewSubscription(int $id, int $months = null): Subscription
    {
        return DB::transaction(function () use ($id, $months) {
            $subscription = $this->subscriptionRepository->findById($id);

            if (!$subscription) {
                throw new \Exception('الاشتراك غير موجود');
            }

            // إذا لم يتم تحديد المدة، نأخذ المدة الأصلية
            if (!$months) {
                $months = $subscription->duration_months ?? 1;
            }

            // تجديد الاشتراك
            $renewed = $this->subscriptionRepository->renew($id, $months);

            // تحديث العميل
            $customer = Customer::find($subscription->customer_id);
            if ($customer) {
                $newExpiry = $customer->expiry_date
                    ? Carbon::parse($customer->expiry_date)->addMonths($months)
                    : now()->addMonths($months);

                $customer->update([
                    'expiry_date' => $newExpiry,
                    'status' => 'active',
                ]);
            }

            // تفعيل مستخدم MikroTik
            if ($customer) {
                $this->enableMikrotikUser($customer);
            }

            Log::info("تم تجديد الاشتراك: {$subscription->id} - {$months} شهور");
            return $renewed;
        });
    }

    /**
     * إلغاء اشتراك
     */
    public function cancelSubscription(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $subscription = $this->subscriptionRepository->findById($id);

            if (!$subscription) {
                throw new \Exception('الاشتراك غير موجود');
            }

            // إلغاء الاشتراك
            $cancelled = $this->subscriptionRepository->cancel($id);

            // تحديث العميل
            $customer = Customer::find($subscription->customer_id);
            if ($customer) {
                $customer->update([
                    'status' => 'suspended',
                ]);
            }

            // تعطيل مستخدم MikroTik
            if ($customer) {
                $this->disableMikrotikUser($customer);
            }

            Log::info("تم إلغاء الاشتراك: {$subscription->id}");
            return $cancelled;
        });
    }

    /**
     * إنشاء مستخدم MikroTik
     */
    protected function createMikrotikUser(Customer $customer, Package $package, Subscription $subscription): void
    {
        try {
            $username = 'user_' . $customer->id;
            $password = 'pass_' . uniqid();

            // تحديث بيانات العميل
            $customer->update([
                'username' => $username,
                'password' => $password,
            ]);

            // إنشاء المستخدم في MikroTik
            $this->mikrotikService->createUser(
                $username,
                $password,
                $package->mikrotik_profile,
                [
                    'comment' => "Customer: {$customer->name} - Subscription: {$subscription->id}",
                    'disabled' => false,
                ]
            );

            Log::info("تم إنشاء مستخدم MikroTik: {$username}");
        } catch (\Exception $e) {
            Log::error("فشل إنشاء مستخدم MikroTik: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * تحديث مستخدم MikroTik
     */
    protected function updateMikrotikUser(Customer $customer, Package $package): void
    {
        try {
            if ($customer->username) {
                // تحديث حدود السرعة
                $this->mikrotikService->updateUserQueue(
                    $customer->username,
                    $package->speed_download,
                    $package->speed_upload
                );
            }

            Log::info("تم تحديث مستخدم MikroTik: {$customer->username}");
        } catch (\Exception $e) {
            Log::error("فشل تحديث مستخدم MikroTik: " . $e->getMessage());
        }
    }

    /**
     * تفعيل مستخدم MikroTik
     */
    protected function enableMikrotikUser(Customer $customer): void
    {
        try {
            if ($customer->username) {
                $this->mikrotikService->enableUser($customer->username);
            }

            Log::info("تم تفعيل مستخدم MikroTik: {$customer->username}");
        } catch (\Exception $e) {
            Log::error("فشل تفعيل مستخدم MikroTik: " . $e->getMessage());
        }
    }

    /**
     * تعطيل مستخدم MikroTik
     */
    protected function disableMikrotikUser(Customer $customer): void
    {
        try {
            if ($customer->username) {
                $this->mikrotikService->disableUser($customer->username);
            }

            Log::info("تم تعطيل مستخدم MikroTik: {$customer->username}");
        } catch (\Exception $e) {
            Log::error("فشل تعطيل مستخدم MikroTik: " . $e->getMessage());
        }
    }

    /**
     * الحصول على إحصائيات الاشتراكات
     */
    public function getSubscriptionStats(): array
    {
        $total = Subscription::count();
        $active = Subscription::where('status', 'active')->count();
        $expired = Subscription::where('status', 'expired')->count();
        $cancelled = Subscription::where('status', 'cancelled')->count();

        return [
            'total' => $total,
            'active' => $active,
            'expired' => $expired,
            'cancelled' => $cancelled,
            'active_percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
            'expired_percentage' => $total > 0 ? round(($expired / $total) * 100, 2) : 0,
        ];
    }

    /**
     * الحصول على اشتراكات ستنتهي خلال فترة
     */
    public function getExpiringSubscriptions(int $days = 7): array
    {
        $expiryDate = now()->addDays($days);

        return Subscription::where('status', 'active')
            ->where('expiry_date', '<=', $expiryDate)
            ->where('expiry_date', '>', now())
            ->with(['customer', 'package'])
            ->get()
            ->toArray();
    }

    /**
     * إنهاء الاشتراكات المنتهية تلقائياً
     */
    public function autoExpireSubscriptions(): int
    {
        $expiredSubscriptions = Subscription::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            try {
                DB::transaction(function () use ($subscription) {
                    // تحديث الاشتراك
                    $subscription->update(['status' => 'expired']);

                    // تحديث العميل
                    $customer = Customer::find($subscription->customer_id);
                    if ($customer) {
                        $customer->update([
                            'status' => 'expired',
                        ]);
                    }

                    // تعطيل مستخدم MikroTik
                    if ($customer && $customer->username) {
                        $this->disableMikrotikUser($customer);
                    }

                    $count++;
                });
            } catch (\Exception $e) {
                Log::error("فشل إنهاء الاشتراك: {$subscription->id} - " . $e->getMessage());
            }
        }

        Log::info("تم إنهاء {$count} اشتراك منتهي تلقائياً");
        return $count;
    }

    /**
     * البحث عن الاشتراكات
     */
    public function searchSubscriptions(string $searchTerm, int $perPage = 15)
    {
        return $this->subscriptionRepository->getAll(['search' => $searchTerm], $perPage);
    }

    public function activate(Subscription $subscription): bool
    {
        return $this->activateAction->execute($subscription);
    }

    public function suspend(Subscription $subscription): bool
    {
        return $this->suspendAction->execute($subscription);
    }

    public function expire(Subscription $subscription): bool
    {
        return $this->expireAction->execute($subscription);
    }

    public function restore(Subscription $subscription): bool
    {
        return $this->restoreAction->execute($subscription);
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): bool {
        return $this->renewAction->execute(
            $subscription,
            $days
        );
    }
}
