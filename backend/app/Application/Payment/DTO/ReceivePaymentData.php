<?php

declare(strict_types=1);

namespace App\Application\Payment\DTO;

final readonly class ReceivePaymentData
{
    public function __construct(
        public array $attributes,
    ) {}
}
