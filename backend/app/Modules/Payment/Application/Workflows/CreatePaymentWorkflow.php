<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Workflows;

use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Payment\Application\Actions\CreatePaymentAction;

final readonly class CreatePaymentWorkflow
{
    public function __construct(
        private CreatePaymentAction $createPayment,
    ) {}

    public function execute(
        array $data,
    ): Payment {

        return $this->createPayment->execute(
            $data,
        );
    }
}
