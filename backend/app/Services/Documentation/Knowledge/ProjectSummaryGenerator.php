<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class ProjectSummaryGenerator
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function generate(): string
    {
        $models = count($this->scanner->models());
        $services = count($this->scanner->services());

        return implode(PHP_EOL, [
            '# Project Summary',
            '',
            'Project: EgyptNet ISP Management System',
            '',
            'Technology',
            '- Laravel 13',
            '- PHP 8.4',
            '- Docker',
            '- MikroTik RouterOS',
            '',
            'Statistics',
            "- Models: {$models}",
            "- Services: {$services}",
        ]);
    }
}
