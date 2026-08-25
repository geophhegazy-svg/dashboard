<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Reports\Application\Export\CsvExporter;
use App\Modules\Reports\Application\Manager\ExportManager;
use App\Modules\Reports\Application\Manager\ReportManager;
use App\Modules\Reports\Application\Registry\ReportRegistry;
use App\Modules\Reports\Application\Reports\CustomerReport;
use App\Modules\Reports\Application\Reports\InvoiceReport;
use App\Modules\Reports\Application\Reports\PaymentReport;
use App\Modules\Reports\Application\Reports\SubscriptionReport;
use App\Modules\Reports\Application\Reports\WalletReport;
use App\Modules\Reports\Infrastructure\Export\ExcelExporter;
use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ReportRegistry::class, function ($app) {
            $registry = new ReportRegistry();

            $registry->register(new CustomerReport());
            $registry->register(new SubscriptionReport());
            $registry->register(
                $app->make(InvoiceReport::class)
            );
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
