<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Handover;

class ExecutiveSummarySection extends AbstractHandoverSection
{
    public function generate(): string
    {
        return implode(PHP_EOL, [

            $this->heading(
                1,
                'Executive Summary'
            ),

            '',

            $this->generated(
                'PROJECT_SUMMARY.md'
            ),

            '',

        ]);
    }
}
