<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

interface KnowledgeGeneratorInterface
{
    public function filename(): string;

    public function generate(): string;
}
