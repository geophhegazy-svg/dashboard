<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class CustomerProfileSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_customer_profile(): void
    {
        $response = $this->get('/customer/profile');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_update_customer_profile(): void
    {
        $response = $this->put('/customer/profile', [
            'name' => 'Changed Name',
            'email' => 'changed@example.com',
            'phone' => '01000000000',
            'address' => 'Changed Address',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_authenticated_customer_can_update_own_profile(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'phone' => '01011111111',
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->put('/customer/profile', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '01022222222',
            'address' => 'Updated Address',
        ]);

        $response->assertRedirect();

        $customer->refresh();

        $this->assertSame('Updated Name', $customer->name);
        $this->assertSame('updated@example.com', $customer->email);
        $this->assertSame('01022222222', $customer->phone);
        $this->assertSame('Updated Address', $customer->address);
    }

    public function test_authenticated_customer_can_change_password(): void
    {
        $customer = Customer::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post('/customer/profile/change-password', [
            'current_password' => 'old-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();

        $customer->refresh();

        $this->assertTrue(
            Hash::check('new-password', $customer->password)
        );
    }

    public function test_customer_cannot_change_password_with_wrong_current_password(): void
    {
        $customer = Customer::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post('/customer/profile/change-password', [
            'current_password' => 'wrong-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password');

        $customer->refresh();

        $this->assertTrue(
            Hash::check('old-password', $customer->password)
        );

        $this->assertFalse(
            Hash::check('new-password', $customer->password)
        );
    }
}
