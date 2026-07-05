<?php

declare(strict_types=1);

namespace App\Services\Documentation\Registry;

use App\Services\Documentation\Generators\GeneratorInterface;

class DocumentationGeneratorRegistry
{
    /**
     * @var GeneratorInterface[]
     */
    protected array $generators = [];

    public function register(GeneratorInterface $generator): self
    {
        $this->generators[] = $generator;

        return $this;
    }

    /**
     * @return GeneratorInterface[]
     */
    public function all(): array
    {
        usort(
            $this->generators,
            fn($a, $b) => $a->priority() <=> $b->priority()
        );

        return $this->generators;
    }
}
