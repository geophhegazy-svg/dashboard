<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class KnowledgeIndexGenerator implements KnowledgeGeneratorInterface
{
    public function filename(): string
    {
        return 'INDEX.md';
    }

    public function generate(): string
    {
        $files = glob(base_path('docs/generated/*.md')) ?: [];

        sort($files);

        $md = [];

        $md[] = '# Knowledge Index';
        $md[] = '';

        foreach ($files as $file) {

            $name = basename($file);

            if ($name === 'INDEX.md') {
                continue;
            }

            $md[] = "- {$name}";
        }

        return implode(PHP_EOL, $md);
    }
}
