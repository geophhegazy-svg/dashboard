<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter extends AbstractExporter
{
    public function name(): string
    {
        return 'xlsx';
    }

    public function export(
        ReportResult $report
    ): ExportResult {

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($report->headers as $index => $header) {
            $sheet->setCellValue(
                Coordinate::stringFromColumnIndex($index + 1) . '1',
                $header
            );
        }

        foreach ($report->rows as $rowIndex => $row) {

            foreach ($row as $columnIndex => $value) {

                $sheet->setCellValue(
                    Coordinate::stringFromColumnIndex($columnIndex + 1) . ($rowIndex + 2),
                    $value
                );
            }
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();

        $writer->save('php://output');

        $content = (string) ob_get_clean();

        return $this->createResult(
            report: $report,
            extension: 'xlsx',
            mimeType: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            content: $content,
        );
    }
}
