<?php

declare(strict_types=1);

use App\Modules\Accounting\Domain\Enums\AccountingPeriodStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_periods', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->enum(
                'status',
                AccountingPeriodStatus::values(),
            )->default(AccountingPeriodStatus::OPEN->value);

            $table->timestamps();

            $table->unique([
                'tenant_id',
                'start_date',
                'end_date',
            ]);

            $table->index([
                'tenant_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_periods');
    }
};
