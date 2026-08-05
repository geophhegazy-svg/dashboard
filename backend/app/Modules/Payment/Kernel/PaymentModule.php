<?php

declare(strict_types=1);

namespace App\Modules\Payment\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Repositories\PaymentRepository;

final class PaymentModule extends Module
{
    public function name(): string
    {
        return 'Payment';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                PaymentRepositoryInterface::class
                => PaymentRepository::class,

            ]);
    }
}
