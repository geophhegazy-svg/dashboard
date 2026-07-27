# TODO

- **app/Modules/Documentation/Application/Exports/AiStartPromptExport.php**:36 — - TODO.md
- **app/Modules/Documentation/Application/Knowledge/KnowledgeExporter.php**:65 — - TODO.md
- **app/Modules/Documentation/Application/Knowledge/KnowledgeGeneratorRegistry.php**:92 — new TodoKnowledgeGenerator()
- **app/Modules/Documentation/Application/Knowledge/TodoGenerator.php**:7 — class TodoGenerator implements KnowledgeExtractorInterface
- **app/Modules/Documentation/Application/Knowledge/TodoGenerator.php**:11 — $todos = [];
- **app/Modules/Documentation/Application/Knowledge/TodoGenerator.php**:27 — if (preg_match('/TODO|FIXME|XXX/i', $line)) {
- **app/Modules/Documentation/Application/Knowledge/TodoGenerator.php**:29 — $todos[] = [
- **app/Modules/Documentation/Application/Knowledge/TodoGenerator.php**:42 — return $todos;
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:7 — class TodoKnowledgeGenerator implements KnowledgeGeneratorInterface
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:10 — protected TodoGenerator $extractor = new TodoGenerator()
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:15 — return 'TODO.md';
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:20 — $todos = $this->extractor->extract();
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:24 — $md[] = '# TODO';
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:27 — if (empty($todos)) {
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:29 — $md[] = 'No TODO items found.';
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:34 — foreach ($todos as $todo) {
- **app/Modules/Documentation/Application/Knowledge/TodoKnowledgeGenerator.php**:37 — "- **{$todo['file']}**:{$todo['line']} — {$todo['text']}";