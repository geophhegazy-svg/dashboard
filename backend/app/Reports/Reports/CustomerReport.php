<?php

declare(strict_types=1);

namespace App\Reports\Reports;

use App\Models\Customer;
use App\Reports\Abstracts\BaseReport;
use Illuminate\Database\Eloquent\Builder;

class CustomerReport extends BaseReport
{
    public function name(): string
    {
        return 'customers';
    }

    public function title(): string
    {
        return 'Customers Report';
    }

    protected function query(): Builder
    {
        return Customer::query()
            ->with([
                'subscriptions',
            ]);
    }

    protected function headers(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'Email',
            'Status',
            'Subscriptions',
            'Created At',
        ];
    }

    protected function map(
        iterable $records
    ): array {

        $rows = [];

        foreach ($records as $customer) {

            $rows[] = [

                'id' => $customer->id,

                'name' => $customer->name,

                'phone' => $customer->phone,

                'email' => $customer->email,

                'status' => $customer->status,

                'subscriptions' => $customer->subscriptions->count(),

                'created_at' => optional(
                    $customer->created_at
                )->toDateTimeString(),

            ];
        }

        return $rows;
    }

    protected function summary(
        array $rows
    ): array {

        return [

            'total_customers' => count($rows),

            'active_customers' => collect($rows)
                ->where('status', 'active')
                ->count(),

            'inactive_customers' => collect($rows)
                ->where('status', 'inactive')
                ->count(),

        ];
    }
}
