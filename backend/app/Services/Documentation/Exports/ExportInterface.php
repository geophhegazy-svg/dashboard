<?php

declare(strict_types=1);

namespace App\Services\Documentation\Exports;

interface ExportInterface
{
    /**
     * اسم الملف النهائي.
     */
    public function filename(): string;

    /**
     * محتوى الملف.
     */
    public function content(): string;

    /**
     * هل يتم تصديره داخل docs/generated/ai
     */
    public function isAiExport(): bool;
}
