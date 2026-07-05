<?php

declare(strict_types=1);

namespace App\Services\Documentation\Generators;

interface GeneratorInterface
{
    public function filename(): string;

    public function generate(): string;
}
