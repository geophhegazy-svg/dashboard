<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Application\Actions\GetCustomerTicketStatisticsAction;

final readonly class GetCustomerTicketStatisticsWorkflow
{
    public function __construct(
        private GetCustomerTicketStatisticsAction $action,
    ) {}

    public function execute(
        Customer $customer,
    ): array {

        return $this->action->execute(
            $customer,
        );
    }
}
