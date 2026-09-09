<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tenant;
use Laravel\Sanctum\Sanctum;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PackageBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);
    }

    private function validPayload(Tenant $tenant): array
    {
        return [
            'tenant_id' => $tenant->id,
            'name' => 'Test Package',
            'download_speed' => 10,
            'upload_speed' => 5,
            'price' => 100,
            'quota_gb' => 100,
            'status' => 'active',
            'description' => 'Package business rule test',
        ];
    }

    public function test_store_rejects_negative_price(): void
    {
        $this->login();
        $tenant = Tenant::factory()->create();

        $payload = $this->validPayload($tenant);
        $payload['price'] = -1;

        $this->postJson('/api/packages', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    public function test_store_rejects_negative_quota(): void
    {
        $this->login();
        $tenant = Tenant::factory()->create();

        $payload = $this->validPayload($tenant);
        $payload['quota_gb'] = -1;

        $this->postJson('/api/packages', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['quota_gb']);
    }

    public function test_update_rejects_negative_price(): void
    {
        $this->login();
        $tenant = Tenant::factory()->create();

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'price' => 100,
            'quota_gb' => 100,
        ]);

        $payload = $this->validPayload($tenant);
        $payload['price'] = -1;

        $this->putJson("/api/packages/{$package->id}", $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['price']);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'price' => 100,
        ]);
    }

    public function test_update_rejects_negative_quota(): void
    {
        $this->login();
        $tenant = Tenant::factory()->create();

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'price' => 100,
            'quota_gb' => 100,
        ]);

        $payload = $this->validPayload($tenant);
        $payload['quota_gb'] = -1;

        $this->putJson("/api/packages/{$package->id}", $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['quota_gb']);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'quota_gb' => 100,
        ]);
    }
}
