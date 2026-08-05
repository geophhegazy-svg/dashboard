<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Workflows;

use App\Modules\Payment\Application\DTO\ReceivePaymentData;
use App\Modules\Payment\Application\Validators\ReceivePaymentValidator;
use App\Core\Workflow\AbstractWorkflow;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Payment\Application\Services\PaymentService;

final class ReceivePaymentWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly ReceivePaymentValidator $validator,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): Payment {

        /** @var ReceivePaymentData $data */
        $data = $arguments[0];

        $this->validator->validate($data);

        return $this->paymentService->create(
            $data->attributes
        );
    }
}
