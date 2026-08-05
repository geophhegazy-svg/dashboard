<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Wallet\Application\Actions\DeductWalletAction;
use App\Modules\Wallet\Application\Actions\DepositWalletAction;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Wallet\Infrastructure\Repositories\WalletRepository;
use App\Modules\Wallet\Application\Workflows\DepositWalletWorkflow;
use App\Modules\Wallet\Application\Workflows\DeductWalletWorkflow;

final class WalletModule extends Module
{
    public function name(): string
    {
        return 'Wallet';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Subscription\Kernel\SubscriptionModule::class,
            \App\Modules\Activity\Kernel\ActivityModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                WalletRepositoryInterface::class
                => WalletRepository::class,

                DepositWalletWorkflow::class
                => DepositWalletWorkflow::class,

                DeductWalletWorkflow::class
                => DeductWalletWorkflow::class,

            ])

            ->actions([

                DepositWalletAction::class,

                DeductWalletAction::class,

            ]);
    }
}
