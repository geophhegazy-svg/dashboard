<?php

declare(strict_types=1);

namespace App\Reports\Reports;

use App\Models\Subscription;
use App\Reports\Abstracts\BaseReport;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionReport extends BaseReport
{
    public function name(): string
    {
        return 'subscriptions';
    }

    public function title(): string
    {
        return 'Subscriptions Report';
    }

    protected function query(): Builder
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ]);
    }

    protected function headers(): array
    {
        return [
            'ID',
            'Customer',
            'Package',
            'Monthly Price',
            'Status',
            'Wallet Balance',
            'PPPoE Username',
            'MikroTik Profile',
            'Start Date',
            'End Date',
        ];
    }

    protected function map(
        iterable $records
    ): array {

        $rows = [];

        foreach ($records as $subscription) {

            $rows[] = [

                'id' => $subscription->id,

                'customer' => $subscription->customer?->name,

                'package' => $subscription->package?->name,

                'monthly_price' => (float) $subscription->monthly_price,

                'status' => $subscription->status instanceof \BackedEnum
                    ? $subscription->status->value
                    : $subscription->status,

                'wallet_balance' => (float) ($subscription->wallet_balance ?? 0),

                'pppoe_username' => $subscription->pppoe_username,

                'mikrotik_profile' => $subscription->mikrotik_profile,

                'start_date' => optional(
                    $subscription->start_date
                )->toDateString(),

                'end_date' => optional(
                    $subscription->end_date
                )->toDateString(),

            ];
        }

        return $rows;
    }

    protected function summary(
        array $rows
    ): array {

        return [

            'total_subscriptions' => count($rows),

            'active' => collect($rows)
                ->where('status', 'active')
                ->count(),

            'suspended' => collect($rows)
                ->where('status', 'suspended')
                ->count(),

            'expired' => collect($rows)
                ->where('status', 'expired')
                ->count(),

            'total_monthly_revenue' => collect($rows)
                ->sum('monthly_price'),

            'average_subscription_price' => round(
                collect($rows)->avg('monthly_price') ?? 0,
                2
            ),

            'total_wallet_balance' => collect($rows)
                ->sum('wallet_balance'),

        ];
    }
}
