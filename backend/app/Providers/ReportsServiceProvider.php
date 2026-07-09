<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Reports\Registry\ReportRegistry;
use App\Reports\Reports\CustomerReport;
use App\Reports\Reports\SubscriptionReport;
use App\Reports\Reports\InvoiceReport;
use App\Reports\Reports\PaymentReport;
use App\Reports\Reports\WalletReport;

class ReportsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ReportRegistry::class,
            function () {

                $registry = new ReportRegistry();

                $registry->register(
                    new CustomerReport()
                );

                $registry->register(
                    new SubscriptionReport()
                );

                $registry->register(
                    new InvoiceReport()
                );

                $registry->register(
                    new PaymentReport()
                );

                $registry->register(
                    new WalletReport()
                );

                return $registry;
            }
        );

        $this->app->singleton(
            \App\Reports\Export\ExportManager::class,
            function () {

                $manager = new \App\Reports\Export\ExportManager();

                $manager->register(
                    new \App\Reports\Export\CsvExporter()
                );

                return $manager;
            }
        );
    }

    public function boot(): void
    {
        //
    }
}
