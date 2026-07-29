<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Workflows;

use App\Modules\Payment\Application\DTO\ReceivePaymentData;
use App\Modules\Payment\Application\Results\WorkflowResult;
use App\Modules\Payment\Application\Validators\ReceivePaymentValidator;

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
