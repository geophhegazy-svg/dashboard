# TODO

- **app/Services/Documentation/Knowledge/KnowledgeGeneratorRegistry.php**:92 — new TodoKnowledgeGenerator()
- **app/Services/Documentation/Knowledge/TodoGenerator.php**:7 — class TodoGenerator implements KnowledgeExtractorInterface
- **app/Services/Documentation/Knowledge/TodoGenerator.php**:11 — $todos = [];
- **app/Services/Documentation/Knowledge/TodoGenerator.php**:27 — if (preg_match('/TODO|FIXME|XXX/i', $line)) {
- **app/Services/Documentation/Knowledge/TodoGenerator.php**:29 — $todos[] = [
- **app/Services/Documentation/Knowledge/TodoGenerator.php**:42 — return $todos;
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:7 — class TodoKnowledgeGenerator implements KnowledgeGeneratorInterface
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:10 — protected TodoGenerator $extractor = new TodoGenerator()
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:15 — return 'TODO.md';
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:20 — $todos = $this->extractor->extract();
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:24 — $md[] = '# TODO';
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:27 — if (empty($todos)) {
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:29 — $md[] = 'No TODO items found.';
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:34 — foreach ($todos as $todo) {
- **app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php**:37 — "- **{$todo['file']}**:{$todo['line']} — {$todo['text']}";