<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Contract;

use Tests\TestCase;

class CorsBoundaryContractTest extends TestCase
{
    public function test_api_actual_request_exposes_framework_cors_contract(): void
    {
        $response = $this
            ->withHeader('Origin', 'http://frontend.example.test')
            ->getJson('/api/dashboard');

        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $response->assertHeaderMissing('Access-Control-Allow-Credentials');
    }

    public function test_api_preflight_exposes_framework_cors_contract(): void
    {
        $response = $this
            ->withHeaders([
                'Origin' => 'http://frontend.example.test',
                'Access-Control-Request-Method' => 'GET',
                'Access-Control-Request-Headers' => 'Authorization, Content-Type',
            ])
            ->options('/api/dashboard');

        $response
            ->assertNoContent()
            ->assertHeader('Access-Control-Allow-Origin', '*')
            ->assertHeader('Access-Control-Allow-Methods', 'GET')
            ->assertHeader(
                'Access-Control-Allow-Headers',
                'Authorization, Content-Type'
            )
            ->assertHeaderMissing('Access-Control-Allow-Credentials');
    }

    public function test_cors_contract_does_not_enable_credentials(): void
    {
        $response = $this
            ->withHeaders([
                'Origin' => 'http://frontend.example.test',
                'Cookie' => 'laravel_session=fake',
            ])
            ->getJson('/api/login');

        $response->assertHeaderMissing('Access-Control-Allow-Credentials');
    }
}
