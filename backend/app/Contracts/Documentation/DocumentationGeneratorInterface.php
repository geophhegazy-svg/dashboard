<?php

declare(strict_types=1);

namespace App\Contracts\Documentation;

interface DocumentationGeneratorInterface
{
    public function generate(): void;
}
