<?php

declare(strict_types=1);

namespace App\Automation\Services;

use App\Automation\Actions\GenerateInvoicesAction;
use App\Automation\Contracts\AutomationServiceInterface;
use App\Automation\DTOs\AutomationResult;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class AutomaticInvoiceGenerationService implements AutomationServiceInterface
{
    public function __construct(
        private GenerateInvoicesAction $action,
    ) {}

    public function run(): AutomationResult
    {
        $processed = 0;
        $created = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];

        Subscription::query()
            ->where('status', 'active')
            ->whereDate('next_invoice_date', '<=', today())
            ->chunkById(100, function ($subscriptions) use (
                &$processed,
                &$created,
                &$skipped,
                &$failed,
                &$errors
            ) {
                foreach ($subscriptions as $subscription) {

                    $processed++;

                    try {

                        $this->action->execute($subscription);

                        $created++;
                    } catch (\Throwable $e) {

                        $failed++;

                        $errors[] = sprintf(
                            'Subscription #%d: %s',
                            $subscription->id,
                            $e->getMessage()
                        );
                    }
                }
            });

        return new AutomationResult(
            processed: $processed,
            created: $created,
            skipped: $skipped,
            failed: $failed,
            errors: $errors,
        );
    }
}
