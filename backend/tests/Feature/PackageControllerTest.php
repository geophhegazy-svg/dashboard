<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageControllerTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);
    }

    public function test_index_returns_packages(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        Package::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->getJson('/api/packages')
            ->assertOk();
    }

    public function test_store_creates_package(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $this->postJson('/api/packages', [
            'tenant_id' => $tenant->id,
            'name' => 'Fiber 200',
            'download_speed' => 200,
            'upload_speed' => 50,
            'price' => 500,
            'status' => 'active',
        ])->assertSuccessful();

        $this->assertDatabaseHas('packages', [
            'name' => 'Fiber 200',
        ]);
    }

    public function test_show_returns_package_contract_fields(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'quota_gb' => 500,
            'status' => 'inactive',
        ]);

        $this->getJson("/api/packages/{$package->id}")
            ->assertOk()
            ->assertJsonPath('data.quota_gb', 500)
            ->assertJsonPath('data.status', 'inactive');
    }

    public function test_delete_package(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->deleteJson("/api/packages/{$package->id}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('packages', [
            'id' => $package->id,
        ]);
    }
}


