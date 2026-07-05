<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class TodoKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected TodoGenerator $extractor = new TodoGenerator()
    ) {}

    public function filename(): string
    {
        return 'TODO.md';
    }

    public function generate(): string
    {
        $todos = $this->extractor->extract();

        $md = [];

        $md[] = '# TODO';
        $md[] = '';

        if (empty($todos)) {

            $md[] = 'No TODO items found.';

            return implode(PHP_EOL, $md);
        }

        foreach ($todos as $todo) {

            $md[] =
                "- **{$todo['file']}**:{$todo['line']} — {$todo['text']}";
        }

        return implode(PHP_EOL, $md);
    }
}
