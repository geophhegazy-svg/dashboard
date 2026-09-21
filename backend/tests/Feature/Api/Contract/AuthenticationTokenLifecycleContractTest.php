<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Contract;

use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTokenLifecycleContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_token_lifecycle_is_real_bearer_token_based(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $login
            ->assertOk()
            ->assertJsonStructure([
                'token',
                'user',
            ])
            ->assertJsonPath('user.id', $user->id);

        $token = $login->json('token');

        $this->assertIsString($token);
        $this->assertNotSame('', $token);

        $this->withToken($token)
            ->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('id', $user->id);

        $this->withToken($token)
            ->postJson('/api/logout')
            ->assertOk()
            ->assertJson([
                'message' => 'Logged out',
            ]);

        $this->app['auth']->forgetGuards();

        $this->withToken($token)
            ->getJson('/api/me')
            ->assertUnauthorized();
    }

    public function test_customer_token_lifecycle_is_real_bearer_token_based(): void
    {
        $customer = Customer::factory()->create([
            'password' => 'password',
        ]);

        $login = $this->postJson('/api/customer/login', [
            'phone' => $customer->phone,
            'password' => 'password',
        ]);

        $login
            ->assertOk()
            ->assertJsonStructure([
                'token',
                'customer',
            ])
            ->assertJsonPath('customer.id', $customer->id);

        $token = $login->json('token');

        $this->assertIsString($token);
        $this->assertNotSame('', $token);

        $this->withToken($token)
            ->getJson('/api/customer/me')
            ->assertOk()
            ->assertJsonPath('id', $customer->id);

        $this->withToken($token)
            ->postJson('/api/customer/logout')
            ->assertOk()
            ->assertJson([
                'message' => 'Logged out successfully',
            ]);

        $this->app['auth']->forgetGuards();

        $this->withToken($token)
            ->getJson('/api/customer/me')
            ->assertUnauthorized();
    }
}
