<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Customer;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CustomerCrudContractTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::factory()->create();

        $this->user = User::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);

        foreach ([
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',
        ] as $permission) {
            Permission::findOrCreate($permission, 'web');
            $this->user->givePermissionTo($permission);
        }

        Sanctum::actingAs($this->user);
    }

    public function test_authorized_user_can_list_customers(): void
    {
        Customer::factory()->count(2)->create(['tenant_id' => $this->tenant->id]);

        $response = $this->getJson('/api/customers');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_authorized_user_can_create_customer_with_all_supported_fields(): void
    {
        $payload = [
            'name' => 'CRUD Customer',
            'phone' => '01012345678',
            'email' => 'crud@example.com',
            'address' => 'Alexandria',
            'national_id' => '29801011234567',
            'status' => 'active',
            'notes' => 'Customer contract test',
        ];

        $response = $this->postJson('/api/customers', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'CRUD Customer')
            ->assertJsonPath('data.national_id', '29801011234567')
            ->assertJsonPath('data.notes', 'Customer contract test');

        $this->assertDatabaseHas('customers', [
            'name' => 'CRUD Customer',
            'email' => 'crud@example.com',
            'national_id' => '29801011234567',
            'notes' => 'Customer contract test',
        ]);
    }

    public function test_authorized_user_can_show_customer(): void
    {
        $customer = Customer::factory()->create(['tenant_id' => $this->tenant->id]);

        $response = $this->getJson("/api/customers/{$customer->id}");

        $response
            ->assertOk()
            ->assertJsonPath('data.id', $customer->id)
            ->assertJsonPath('data.name', $customer->name);
    }

    public function test_authorized_user_can_update_customer_using_same_email(): void
    {
        $customer = Customer::factory()->create([
            'tenant_id' => $this->tenant->id,
            'email' => 'same@example.com',
            'national_id' => null,
            'notes' => null,
        ]);

        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Updated Customer',
            'phone' => '01098765432',
            'email' => 'same@example.com',
            'address' => 'Updated Address',
            'national_id' => '29902021234567',
            'status' => 'active',
            'notes' => 'Updated notes',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Customer')
            ->assertJsonPath('data.email', 'same@example.com')
            ->assertJsonPath('data.national_id', '29902021234567')
            ->assertJsonPath('data.notes', 'Updated notes');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'email' => 'same@example.com',
            'national_id' => '29902021234567',
            'notes' => 'Updated notes',
        ]);
    }

    public function test_customer_validation_returns_laravel_422_contract(): void
    {
        $response = $this->postJson('/api/customers', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'phone',
                    'status',
                ],
            ]);
    }

    public function test_authorized_user_can_delete_customer(): void
    {
        $customer = Customer::factory()->create(['tenant_id' => $this->tenant->id]);

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Customer deleted successfully',
            ]);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_user_without_customer_create_permission_is_forbidden(): void
    {
        $this->user->revokePermissionTo('customers.create');

        $response = $this->postJson('/api/customers', [
            'name' => 'Forbidden Customer',
            'phone' => '01012345678',
            'email' => 'forbidden@example.com',
            'status' => 'active',
        ]);

        $response->assertForbidden();
    }
}
