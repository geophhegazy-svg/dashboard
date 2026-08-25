<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Services;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;
use App\Modules\Invoice\Application\Actions\UpdateInvoiceAction;
use App\Modules\Invoice\Application\Actions\DeleteInvoiceAction;
use App\Modules\Invoice\Application\Actions\SettleInvoiceAction;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class InvoiceService implements InvoiceServiceInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
        private CreateInvoiceAction $createInvoice,
        private UpdateInvoiceAction $updateInvoice,
        private DeleteInvoiceAction $deleteInvoice,
        private SettleInvoiceAction $settleInvoice,
    ) {}

    public function findForPayment(
        int $invoiceId,
    ): Invoice {
        return $this->repository->findForPayment(
            $invoiceId,
        );
    }

    public function create(array $data): Invoice
    {
        $invoice = $this->repository->findBySubscriptionId(
            $data['subscription_id'],
        );

        if ($invoice) {
            return $invoice;
        }

        return $this->createInvoice->execute($data);
    }

    public function createRenewal(array $data): Invoice
    {
        $invoice = $this->repository->findByRenewalKey(
            $data['renewal_key'],
        );

        if ($invoice) {
            return $invoice->fresh([
                'customer',
                'subscription',
            ]);
        }

        return $this->createInvoice->execute($data);
    }

    public function update(
        Invoice $invoice,
        array $data,
    ): Invoice {

        return $this->updateInvoice->execute(
            $invoice,
            $data,
        );
    }

    public function delete(
        Invoice $invoice,
    ): bool {

        return $this->deleteInvoice->execute(
            $invoice,
        );
    }

    public function settle(
        Invoice $invoice,
        float $totalPaid,
    ): Invoice {

        return $this->settleInvoice->execute(
            $invoice,
            $totalPaid,
        );
    }
}
