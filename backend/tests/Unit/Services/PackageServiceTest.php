<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Package;
use App\Services\Package\PackageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Tenant;

class PackageServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_package_can_be_created(): void
    {
        $tenant = Tenant::factory()->create();

        $service = app(PackageService::class);

        $package = $service->create([
            'tenant_id'       => $tenant->id,
            'name'            => 'Fiber 100',
            'download_speed'  => 100,
            'upload_speed'    => 20,
            'price'           => 300,
        ]);

        $this->assertInstanceOf(
            Package::class,
            $package
        );

        $this->assertDatabaseHas('packages', [
            'id'               => $package->id,
            'name'             => 'Fiber 100',
            'download_speed'   => 100,
            'upload_speed'     => 20,
        ]);
    }
}
