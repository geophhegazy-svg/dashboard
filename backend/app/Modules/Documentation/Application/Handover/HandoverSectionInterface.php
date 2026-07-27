<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Handover;

interface HandoverSectionInterface
{
    public function generate(): string;
}
