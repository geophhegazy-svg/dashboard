<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\ActivityLog;
use App\Models\Tenant;
use App\Modules\Activity\Application\Workflows\LogActivityWorkflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_creates_activity_record(): void
    {
        $tenant = Tenant::factory()->create();

        app(LogActivityWorkflow::class)->execute(

            [
                'tenant_id' => $tenant->id,
                'module'    => 'wallet',
                'action'    => 'deposit',
            ],

            [
                'user_id'     => null,
                'description' => 'Wallet credited',
                'ip_address'  => '127.0.0.1',
            ]

        );

        $this->assertDatabaseHas('activity_logs', [
            'tenant_id'   => $tenant->id,
            'user_id'     => null,
            'module'      => 'wallet',
            'action'      => 'deposit',
            'description' => 'Wallet credited',
        ]);

        $this->assertEquals(1, ActivityLog::count());
    }
}
