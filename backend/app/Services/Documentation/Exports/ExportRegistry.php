<?php

declare(strict_types=1);

namespace App\Services\Documentation\Exports;

class ExportRegistry
{
    /**
     * @var array<ExportInterface>
     */
    protected array $exports = [];

    public function __construct()
    {
        $this->register(new AiStartPromptExport());
    }

    public function register(ExportInterface $export): self
    {
        $this->exports[] = $export;

        return $this;
    }

    /**
     * @return array<ExportInterface>
     */
    public function exports(): array
    {
        return $this->exports;
    }
}
