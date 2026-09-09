<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Inventory;

use App\Models\Tenant;
use App\Modules\Inventory\Application\Actions\ReturnDeviceAction;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

final class InventoryBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_is_not_low_stock_above_minimum_quantity(): void
    {
        $inventory = Inventory::factory()->create([
            'quantity' => 6,
            'minimum_quantity' => 5,
        ]);

        $this->assertFalse($inventory->isLowStock());
    }

    public function test_inventory_is_low_stock_at_or_below_minimum_quantity(): void
    {
        $inventory = Inventory::factory()->create([
            'quantity' => 5,
            'minimum_quantity' => 5,
        ]);

        $this->assertTrue($inventory->isLowStock());

        $inventory->update([
            'quantity' => 4,
        ]);

        $this->assertTrue($inventory->fresh()->isLowStock());
    }

    public function test_returning_device_marks_assignment_returned_sets_timestamp_and_increments_inventory(): void
    {
        $tenant = Tenant::factory()->create();

        $device = Device::factory()->create([
            'tenant_id' => $tenant->id,
            'device_type' => 'router',
            'brand' => 'TestBrand',
            'model' => 'TestModel',
        ]);

        $assignment = DeviceAssignment::factory()->create([
            'tenant_id' => $tenant->id,
            'device_id' => $device->id,
            'status' => 'assigned',
            'returned_at' => null,
        ]);

        $inventory = Inventory::factory()->create([
            'tenant_id' => $tenant->id,
            'device_type' => 'router',
            'brand' => 'TestBrand',
            'model' => 'TestModel',
            'quantity' => 2,
        ]);

        app(ReturnDeviceAction::class)->execute($assignment);

        $this->assertDatabaseHas('device_assignments', [
            'id' => $assignment->id,
            'status' => 'returned',
        ]);

        $this->assertNotNull(
            $assignment->fresh()->returned_at
        );

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'quantity' => 3,
        ]);
    }

    public function test_returning_already_returned_device_is_rejected(): void
    {
        $assignment = DeviceAssignment::factory()->create([
            'status' => 'returned',
        ]);

        try {
            app(ReturnDeviceAction::class)->execute($assignment);

            $this->fail(
                'Expected already returned device to be rejected.'
            );
        } catch (HttpException $exception) {
            $this->assertSame(
                422,
                $exception->getStatusCode()
            );

            $this->assertSame(
                'Device already returned',
                $exception->getMessage()
            );
        }
    }
}
