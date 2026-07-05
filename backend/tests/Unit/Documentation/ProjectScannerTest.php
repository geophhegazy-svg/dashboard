<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Scanner\ProjectScanner;
use Tests\TestCase;

class ProjectScannerTest extends TestCase
{
    public function test_models_are_discovered(): void
    {
        $scanner = new ProjectScanner();

        $models = $scanner->models();

        $this->assertNotEmpty($models);

        $names = array_column($models, 'name');

        $this->assertContains('Customer', $names);
        $this->assertContains('Subscription', $names);
        $this->assertContains('Invoice', $names);
    }

    public function test_services_are_discovered(): void
    {
        $scanner = new ProjectScanner();

        $services = $scanner->services();

        $this->assertNotEmpty($services);
    }

    public function test_scan_returns_all_sections(): void
    {
        $scanner = new ProjectScanner();

        $project = $scanner->all();

        $this->assertArrayHasKey('models', $project);

        $this->assertArrayHasKey('services', $project);

        $this->assertArrayHasKey('controllers', $project);
    }
}
