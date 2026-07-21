<?php

declare(strict_types=1);

namespace App\Modules\Usage;

use App\Models\Customer;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\UsageSnapshot;
use Illuminate\Support\Collection;

class UsageService
{
    /**
     * جلب بيانات الاستهلاك للعميل بناءً على آخر اشتراك نشط عنده (PPPoE أو Hotspot).
     */
    public function getUsageForCustomer(Customer $customer): array
    {
        $subscription = Subscription::where('customer_id', $customer->id)
            ->latest()
            ->first();

        if ($subscription && $subscription->pppoe_username) {
            return $this->calculate(
                $subscription->pppoe_username,
                'pppoe',
                $subscription->package,
                $subscription->end_date
            );
        }

        $hotspotSubscription = HotspotSubscription::where('customer_id', $customer->id)
            ->latest()
            ->first();

        if ($hotspotSubscription && $hotspotSubscription->hotspot_username) {
            return $this->calculate(
                $hotspotSubscription->hotspot_username,
                'hotspot',
                $hotspotSubscription->package,
                $hotspotSubscription->end_date
            );
        }

        return $this->empty();
    }

    protected function calculate(string $username, string $connectionType, $package, $endDate): array
    {
        // بداية الفترة الحالية = تاريخ انتهاء الاشتراك (آخر تجديد) ناقص شهر.
        // ده بيخلي فترة الاستهلاك بتتظبط لوحدها مع كل تجديد جديد، بدل ما تكون
        // ثابتة على أول كل شهر ميلادي.
        $periodStart = $endDate
            ? \Carbon\Carbon::parse($endDate)->subMonth()
            : now()->startOfMonth();

        $snapshots = UsageSnapshot::where('username', $username)
            ->where('connection_type', $connectionType)
            ->where('recorded_at', '>=', $periodStart)
            ->orderBy('recorded_at')
            ->get(['bytes_download', 'bytes_upload', 'recorded_at']);

        [$downloadUsed, $uploadUsed] = $this->sumDeltas($snapshots);

        $totalUsedBytes = $downloadUsed + $uploadUsed;

        $quotaGb = $package->quota_gb ?? null;
        $quotaBytes = $quotaGb ? $quotaGb * 1024 * 1024 * 1024 : null;

        return [
            'connection_type' => $connectionType,
            'period_start' => $periodStart->toDateString(),
            'bytes_downloaded' => $downloadUsed,
            'bytes_uploaded' => $uploadUsed,
            'bytes_total' => $totalUsedBytes,
            'gb_used' => round($totalUsedBytes / (1024 ** 3), 2),
            'gb_quota' => $quotaGb,
            'gb_remaining' => $quotaBytes
                ? max(0, round(($quotaBytes - $totalUsedBytes) / (1024 ** 3), 2))
                : null,
            'percentage_used' => $quotaBytes
                ? min(100, round(($totalUsedBytes / $quotaBytes) * 100, 1))
                : null,
            'unlimited' => $quotaBytes === null,
        ];
    }

    /**
     * تحسب إجمالي الاستهلاك الحقيقي بين كل لقطة والتانية، مع التعامل مع حالة
     * إعادة تشغيل الراوتر (لما الرقم التراكمي يرجع فجأة أقل من القراءة اللي قبله).
     *
     * @return array{0: int, 1: int} [إجمالي التنزيل, إجمالي الرفع]
     */
    protected function sumDeltas(Collection $snapshots): array
    {
        $downloadTotal = 0;
        $uploadTotal = 0;
        $previous = null;

        foreach ($snapshots as $snapshot) {

            if ($previous === null) {
                $previous = $snapshot;
                continue;
            }

            $downloadTotal += $this->delta($previous->bytes_download, $snapshot->bytes_download);
            $uploadTotal += $this->delta($previous->bytes_upload, $snapshot->bytes_upload);

            $previous = $snapshot;
        }

        return [$downloadTotal, $uploadTotal];
    }

    private function delta(int $previous, int $current): int
    {
        // لو الرقم الحالي أقل من اللي قبله، يبقى الراوتر عمل Reboot أو الـ Queue
        // اتعمله Reset، والقراءة الحالية نفسها هي "الفرق" من نقطة الصفر الجديدة.
        if ($current < $previous) {
            return $current;
        }

        return $current - $previous;
    }

    protected function empty(): array
    {
        return [
            'connection_type' => null,
            'period_start' => null,
            'bytes_downloaded' => 0,
            'bytes_uploaded' => 0,
            'bytes_total' => 0,
            'gb_used' => 0.0,
            'gb_quota' => null,
            'gb_remaining' => null,
            'percentage_used' => null,
            'unlimited' => true,
        ];
    }
}
