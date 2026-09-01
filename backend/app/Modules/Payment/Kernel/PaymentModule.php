<?php

declare(strict_types=1);

namespace App\Modules\Payment\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Repositories\PaymentRepository;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Payment\Policies\PaymentPolicy;

use App\Modules\Payment\Application\Queries\GetPaymentDashboardMetricsQuery;
use App\Modules\Payment\Application\Queries\PaginatePaymentsQuery;
use App\Modules\Payment\Application\Queries\GetRecentPaymentsQuery;

use App\Modules\Payment\Application\Queries\Handlers\GetPaymentDashboardMetricsQueryHandler;
use App\Modules\Payment\Application\Queries\Handlers\PaginatePaymentsQueryHandler;
use App\Modules\Payment\Application\Queries\Handlers\GetRecentPaymentsQueryHandler;

final class PaymentModule extends Module
{
    public function name(): string
    {
        return 'Payment';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Invoice\Kernel\InvoiceModule::class,
            \App\Modules\Wallet\Kernel\WalletModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([
                PaymentRepositoryInterface::class
                => PaymentRepository::class,
            ])

            ->policies([
                Payment::class => PaymentPolicy::class,
            ])

            ->queries([

                GetPaymentDashboardMetricsQuery::class
                => GetPaymentDashboardMetricsQueryHandler::class,

                PaginatePaymentsQuery::class
                => PaginatePaymentsQueryHandler::class,

                GetRecentPaymentsQuery::class
                => GetRecentPaymentsQueryHandler::class,

            ])

            ->listeners([

            ]);
    }
}
