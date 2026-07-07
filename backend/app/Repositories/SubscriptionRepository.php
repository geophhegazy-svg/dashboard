<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Subscription::with(['customer', 'package']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (isset($filters['search'])) {
            $query->whereHas('customer', function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['search']}%")
                    ->orWhere('phone', 'LIKE', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Subscription
    {
        return Subscription::with(['customer', 'package'])->find($id);
    }

    public function getByCustomerId(int $customerId): array
    {
        return Subscription::where('customer_id', $customerId)
            ->with(['package'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function getActiveSubscriptions(): array
    {
        return Subscription::where('status', 'active')
            ->where('expiry_date', '>', now())
            ->with(['customer', 'package'])
            ->get()
            ->toArray();
    }

    public function getExpiredSubscriptions(): array
    {
        return Subscription::where('status', 'expired')
            ->orWhere(function ($q) {
                $q->where('status', 'active')
                    ->where('expiry_date', '<', now());
            })
            ->with(['customer', 'package'])
            ->get()
            ->toArray();
    }

    public function create(array $data): Subscription
    {
        return DB::transaction(function () use ($data) {
            $expiryDate = now()->addMonths($data['duration_months'] ?? 1);

            $subscription = Subscription::create([
                'customer_id' => $data['customer_id'],
                'package_id' => $data['package_id'],
                'start_date' => $data['start_date'] ?? now(),
                'expiry_date' => $data['expiry_date'] ?? $expiryDate,
                'status' => $data['status'] ?? 'active',
                'price' => $data['price'] ?? 0,
                'discount' => $data['discount'] ?? 0,
                'total' => ($data['price'] ?? 0) - ($data['discount'] ?? 0),
                'duration_months' => $data['duration_months'] ?? 1,
                'notes' => $data['notes'] ?? null,
            ]);

            if (isset($data['update_customer']) && $data['update_customer']) {
                Customer::where('id', $data['customer_id'])->update([
                    'status' => 'active',
                    'expiry_date' => $expiryDate,
                    'package_id' => $data['package_id'],
                ]);
            }

            return $subscription;
        });
    }

    public function update(int $id, array $data): Subscription
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($data);
        return $subscription->fresh();
    }

    public function delete(int $id): bool
    {
        return Subscription::findOrFail($id)->delete();
    }

    public function renew(int $id, int $months): Subscription
    {
        return DB::transaction(function () use ($id, $months) {
            $subscription = Subscription::findOrFail($id);
            $newExpiryDate = ($subscription->expiry_date ?? now())->addMonths($months);

            $subscription->update([
                'expiry_date' => $newExpiryDate,
                'status' => 'active',
                'duration_months' => $subscription->duration_months + $months,
            ]);

            Customer::where('id', $subscription->customer_id)->update([
                'expiry_date' => $newExpiryDate,
                'status' => 'active',
            ]);

            return $subscription->fresh();
        });
    }

    public function cancel(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $subscription = Subscription::findOrFail($id);
            $subscription->update(['status' => 'cancelled']);

            Customer::where('id', $subscription->customer_id)->update([
                'status' => 'suspended',
            ]);

            return true;
        });
    }
}
