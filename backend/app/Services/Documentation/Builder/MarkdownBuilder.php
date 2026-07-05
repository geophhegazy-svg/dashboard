<?php

declare(strict_types=1);

namespace App\Services\Documentation\Builder;

class MarkdownBuilder
{
    protected array $lines = [];

    public function title(string $text): self
    {
        $this->lines[] = "# {$text}";
        $this->lines[] = "";

        return $this;
    }

    public function h2(string $text): self
    {
        $this->lines[] = "## {$text}";
        $this->lines[] = "";

        return $this;
    }

    public function h3(string $text): self
    {
        $this->lines[] = "### {$text}";
        $this->lines[] = "";

        return $this;
    }

    public function text(string $text): self
    {
        $this->lines[] = $text;
        $this->lines[] = "";

        return $this;
    }

    public function bullet(string $text): self
    {
        $this->lines[] = "- {$text}";

        return $this;
    }

    public function numbered(int $number, string $text): self
    {
        $this->lines[] = "{$number}. {$text}";

        return $this;
    }

    public function code(string $language, string $code): self
    {
        $this->lines[] = "```{$language}";
        $this->lines[] = $code;
        $this->lines[] = "```";
        $this->lines[] = "";

        return $this;
    }

    public function table(array $headers, array $rows): self
    {
        $this->lines[] = '| ' . implode(' | ', $headers) . ' |';

        $this->lines[] = '| ' . implode(' | ', array_fill(0, count($headers), '---')) . ' |';

        foreach ($rows as $row) {
            $this->lines[] = '| ' . implode(' | ', $row) . ' |';
        }

        $this->lines[] = '';

        return $this;
    }

    public function separator(): self
    {
        $this->lines[] = '';
        $this->lines[] = '---';
        $this->lines[] = '';

        return $this;
    }

    public function newline(): self
    {
        $this->lines[] = '';

        return $this;
    }

    public function render(): string
    {
        return implode(PHP_EOL, $this->lines);
    }
}
