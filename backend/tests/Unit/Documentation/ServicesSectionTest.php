<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Sections\ServicesSection;
use Tests\TestCase;

class ServicesSectionTest extends TestCase
{
    public function test_generates_services_section(): void
    {
        $section = new ServicesSection();

        $markdown = $section->generate();

        $this->assertStringContainsString('# Services', $markdown);
        $this->assertStringContainsString('Count:', $markdown);
        $this->assertStringContainsString('CustomerService', $markdown);
        $this->assertStringContainsString('SubscriptionActivityService', $markdown);
        $this->assertStringContainsString('InvoiceNumberService', $markdown);
    }
}
