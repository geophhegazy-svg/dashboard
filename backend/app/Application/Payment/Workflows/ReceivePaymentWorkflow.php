<?php

declare(strict_types=1);

namespace App\Application\Payment\Workflows;

use App\Application\Payment\DTO\ReceivePaymentData;
use App\Application\Payment\Results\WorkflowResult;
use App\Application\Payment\Validators\ReceivePaymentValidator;

class ReceivePaymentWorkflow
{
    public function __construct(
        protected ReceivePaymentValidator $validator,
    ) {}

    public function handle(
        ReceivePaymentData $data,
    ): WorkflowResult {

        $this->validator->validate($data);

        return new WorkflowResult(
            success: true,
        );
    }
}
