<?php

declare(strict_types=1);

namespace App\Services\Documentation\Handover;

interface HandoverSectionInterface
{
    public function generate(): string;
}
