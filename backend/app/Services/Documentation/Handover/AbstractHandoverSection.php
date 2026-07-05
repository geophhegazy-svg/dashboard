<?php

declare(strict_types=1);

namespace App\Services\Documentation\Handover;

abstract class AbstractHandoverSection implements HandoverSectionInterface
{
    protected function generated(string $file): string
    {
        $path = base_path('docs/generated/' . $file);

        if (! file_exists($path)) {
            return '';
        }

        return trim(
            file_get_contents($path)
        );
    }

    protected function heading(
        int $number,
        string $title
    ): string {
        return "## {$number}. {$title}";
    }
}
