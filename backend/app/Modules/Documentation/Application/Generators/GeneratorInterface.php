<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Generators;

interface GeneratorInterface
{
    public function filename(): string;

    public function generate(): string;
}
