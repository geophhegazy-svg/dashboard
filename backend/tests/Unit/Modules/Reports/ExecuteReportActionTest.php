<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Reports;

use App\Modules\Reports\Application\Contracts\ExporterInterface;
use App\Modules\Reports\Application\DTO\ExportResult;
use App\Modules\Reports\Application\DTO\ReportResult;
use App\Modules\Reports\Application\Filters\ReportFilter;
use App\Modules\Reports\Application\Manager\ExportManager;
use App\Modules\Reports\Application\Manager\ReportManager;
use App\Modules\Reports\Application\Actions\ExecuteReportAction;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ExecuteReportActionTest extends TestCase
{
    private function createExportManager(): ExportManager
    {
        $manager = new ExportManager();

        $manager->register(
            new class implements ExporterInterface {
                public function name(): string
                {
                    return 'csv';
                }

                public function export(
                    ReportResult $report
                ): ExportResult {
                    return new ExportResult(
                        filename: 'customer.csv',
                        mimeType: 'text/csv',
                        content: "id\n1\n",
                        size: 5,
                    );
                }
            }
        );

        return $manager;
    }

    public function test_execute_maps_from_and_to_filters_correctly(): void
    {
        $reportResult = new ReportResult(
            name: 'customer',
            title: 'Customer Report',
            headers: ['id'],
            rows: [
                ['id' => 1],
            ],
        );

        $reportManager = $this->createMock(ReportManager::class);

        $reportManager
            ->expects($this->once())
            ->method('run')
            ->with(
                'customer',
                $this->callback(
                    function (ReportFilter $filter): bool {
                        $this->assertInstanceOf(
                            Carbon::class,
                            $filter->from
                        );

                        $this->assertInstanceOf(
                            Carbon::class,
                            $filter->to
                        );

                        $this->assertSame(
                            '2026-01-01',
                            $filter->from->toDateString()
                        );

                        $this->assertSame(
                            '2026-01-31',
                            $filter->to->toDateString()
                        );

                        $this->assertTrue(
                            $filter->hasDateRange()
                        );

                        return true;
                    }
                )
            )
            ->willReturn($reportResult);

        $service = new ExecuteReportAction(
            reportManager: $reportManager,
            exportManager: $this->createExportManager(),
        );

        $result = $service->execute(
            reportName: 'customer',
            format: 'csv',
            filters: [
                'from' => '2026-01-01',
                'to' => '2026-01-31',
            ],
        );

        $this->assertSame(
            'customer.csv',
            $result->filename
        );

        $this->assertSame(
            'text/csv',
            $result->mimeType
        );
    }

    public function test_execute_supports_from_without_to(): void
    {
        $reportResult = new ReportResult(
            name: 'customer',
            title: 'Customer Report',
            headers: ['id'],
            rows: [],
        );

        $reportManager = $this->createMock(ReportManager::class);

        $reportManager
            ->expects($this->once())
            ->method('run')
            ->with(
                'customer',
                $this->callback(
                    function (ReportFilter $filter): bool {
                        $this->assertSame(
                            '2026-01-01',
                            $filter->from?->toDateString()
                        );

                        $this->assertNull(
                            $filter->to
                        );

                        return true;
                    }
                )
            )
            ->willReturn($reportResult);


        $service = new ExecuteReportAction(
            reportManager: $reportManager,
            exportManager: $this->createExportManager(),
        );

        $service->execute(
            reportName: 'customer',
            format: 'csv',
            filters: [
                'from' => '2026-01-01',
            ],
        );
    }

    public function test_execute_supports_to_without_from(): void
    {
        $reportResult = new ReportResult(
            name: 'customer',
            title: 'Customer Report',
            headers: ['id'],
            rows: [],
        );

        $reportManager = $this->createMock(ReportManager::class);

        $reportManager
            ->expects($this->once())
            ->method('run')
            ->with(
                'customer',
                $this->callback(
                    function (ReportFilter $filter): bool {
                        $this->assertNull(
                            $filter->from
                        );

                        $this->assertSame(
                            '2026-01-31',
                            $filter->to?->toDateString()
                        );

                        return true;
                    }
                )
            )
            ->willReturn($reportResult);


        $service = new ExecuteReportAction(
            reportManager: $reportManager,
            exportManager: $this->createExportManager(),
        );

        $service->execute(
            reportName: 'customer',
            format: 'csv',
            filters: [
                'to' => '2026-01-31',
            ],
        );
    }
}
