<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiValidationErrorContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_errors_use_the_established_json_contract(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/packages', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'tenant_id',
                    'name',
                    'download_speed',
                    'price',
                    'status',
                ],
            ])
            ->assertJsonPath(
                'errors.tenant_id.0',
                'The tenant id field is required.'
            )
            ->assertJsonPath(
                'errors.name.0',
                'The name field is required.'
            )
            ->assertJsonPath(
                'errors.download_speed.0',
                'The download speed field is required.'
            )
            ->assertJsonPath(
                'errors.price.0',
                'The price field is required.'
            )
            ->assertJsonPath(
                'errors.status.0',
                'The status field is required.'
            );
    }
}
