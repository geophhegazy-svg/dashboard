<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

interface KnowledgeGeneratorInterface
{
    public function filename(): string;

    public function generate(): string;
}
