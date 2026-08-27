<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

class KnowledgeGeneratorRegistry
{
    /**
     * @var KnowledgeGeneratorInterface[]
     */
    protected array $generators;

    public function __construct(
        KnowledgeGeneratorInterface ...$generators
    ) {
        $this->generators = $generators;
    }

    public function register(
        KnowledgeGeneratorInterface $generator
    ): self {
        $this->generators[] = $generator;

        return $this;
    }

    /**
     * @return KnowledgeGeneratorInterface[]
     */
    public function generators(): array
    {
        return $this->generators;
    }
}
