<?php

declare(strict_types=1);

namespace App\Modules\Network\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Network\Infrastructure\Services\MikrotikServiceAdapter;
use App\Modules\Network\Domain\Contracts\NetworkProviderResolverInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;

use App\Modules\Network\Infrastructure\Providers\NetworkProviderResolver;
use App\Modules\Network\Infrastructure\Repositories\NetworkDeviceRepository;

use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikConnectionService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikDhcpService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikFirewallService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikHotspotService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikMonitoringService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikPppoeService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueryService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueueService;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Application\Contracts\NetworkDeviceResolverInterface;
use App\Modules\Network\Application\Services\NetworkDeviceResolver;
use App\Modules\Network\Application\Actions\CreateDhcpLeaseAction;
use App\Modules\Network\Application\Actions\UpdateDhcpLeaseAction;
use App\Modules\Network\Application\Actions\DeleteDhcpLeaseAction;
use App\Modules\Network\Application\Actions\CreateFirewallRuleAction;
use App\Modules\Network\Application\Actions\UpdateFirewallRuleAction;
use App\Modules\Network\Application\Actions\DeleteFirewallRuleAction;
use App\Modules\Network\Application\Actions\CreateQueueAction;
use App\Modules\Network\Application\Actions\UpdateQueueAction;
use App\Modules\Network\Application\Actions\ToggleQueueAction;
use App\Modules\Network\Application\Actions\DeleteQueueAction;
use App\Modules\Network\Application\Actions\SyncMikroTikUsersAction;
use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use App\Modules\Network\Presentation\Console\Commands\SyncMikroTikCommand;
use App\Modules\Network\Presentation\Console\Commands\SyncHotspotUsersCommand;
use App\Modules\Network\Application\Listeners\SubscriptionNetworkLifecycleListener;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;

final class NetworkModule extends Module
{
    public function name(): string
    {
        return 'Network';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Subscription\Kernel\SubscriptionModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                
NetworkDeviceRepositoryInterface::class
                    => NetworkDeviceRepository::class,

                NetworkDeviceResolverInterface::class
                    => NetworkDeviceResolver::class,

                MikrotikServiceInterface::class
                    => MikrotikServiceAdapter::class,

                HotspotServiceInterface::class
                    => MikroTikHotspotService::class,

            ])

            ->singletons([

                NetworkManagerInterface::class
                    => NetworkManager::class,

                NetworkManager::class
                    => NetworkManager::class,

                NetworkProviderResolverInterface::class
                    => NetworkProviderResolver::class,

                MikroTikConnectionService::class
                    => MikroTikConnectionService::class,

                MikroTikQueryService::class
                    => MikroTikQueryService::class,

                MikroTikPppoeService::class
                    => MikroTikPppoeService::class,

                MikroTikQueueService::class
                    => MikroTikQueueService::class,

                MikroTikHotspotService::class
                    => MikroTikHotspotService::class,

                MikroTikFirewallService::class
                    => MikroTikFirewallService::class,

                MikroTikDhcpService::class
                    => MikroTikDhcpService::class,

                MikroTikMonitoringService::class
                    => MikroTikMonitoringService::class,

            ])

            ->actions([

                CreateDhcpLeaseAction::class,
                UpdateDhcpLeaseAction::class,
                DeleteDhcpLeaseAction::class,

                CreateFirewallRuleAction::class,
                UpdateFirewallRuleAction::class,
                DeleteFirewallRuleAction::class,

                CreateQueueAction::class,
                UpdateQueueAction::class,
                ToggleQueueAction::class,
                DeleteQueueAction::class,

                SyncMikroTikUsersAction::class,
                SyncHotspotUsersAction::class,

            ])


            ->commands([

                SyncMikroTikCommand::class,

                SyncHotspotUsersCommand::class,

            ])


            ->schedules(function ($schedule): void {

                $schedule->command('mikrotik:sync-hotspot')

                    ->everyFiveMinutes()

                    ->withoutOverlapping();


                $schedule->command('mikrotik:sync')

                    ->everyFiveMinutes()

                    ->withoutOverlapping();

            })


            ->listeners([

                SubscriptionActivated::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionSuspended::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionExpired::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionRestored::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionRenewed::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

            ]);
    }
}
