<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikHotspotService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueryService;
use Mockery;
use RouterOS\Query;
use Tests\TestCase;

final class MikroTikHotspotServiceTest extends TestCase
{
    public function test_hotspot_users_normalize_cp1256_strings_to_utf8(): void
    {
        $query = Mockery::mock(MikroTikQueryService::class);

        $cp1256Comment = hex2bin(
            'c7d3c7e3e520dde5e3ec20c7e1cde6ddec'
        );

        $query->shouldReceive('execute')
            ->once()
            ->with(Mockery::type(Query::class))
            ->andReturn([
                [
                    'name' => 'hotspot01',
                    'comment' => $cp1256Comment,
                ],
            ]);

        $service = new MikroTikHotspotService($query);

        $users = $service->getUsers();

        $this->assertSame(
            'اسامه فهمى الحوفى',
            $users[0]['comment'],
        );

        $this->assertSame(
            1,
            preg_match('//u', $users[0]['comment']),
        );
    }
}
