<?php

declare(strict_types=1);

namespace App\Providers;

use App\Reports\Export\CsvExporter;
use App\Reports\Export\ExcelExporter;
use App\Reports\Export\ExportManager;
use App\Reports\Manager\ReportManager;
use App\Reports\Registry\ReportRegistry;
use App\Reports\Reports\CustomerReport;
use App\Reports\Reports\InvoiceReport;
use App\Reports\Reports\PaymentReport;
use App\Reports\Reports\SubscriptionReport;
use App\Reports\Reports\WalletReport;
use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ReportRegistry::class, function () {

            $registry = new ReportRegistry();

            $registry->register(new CustomerReport());
            $registry->register(new SubscriptionReport());
            $registry->register(new InvoiceReport());
            $registry->register(new PaymentReport());
            $registry->register(new WalletReport());

            return $registry;
        });

        $this->app->singleton(ReportManager::class, function ($app) {

            return new ReportManager(
                $app->make(ReportRegistry::class)
            );
        });

        $this->app->singleton(ExportManager::class, function () {

            $manager = new ExportManager();

            $manager->register(new CsvExporter());
            $manager->register(new ExcelExporter());

            return $manager;
        });
    }
}
