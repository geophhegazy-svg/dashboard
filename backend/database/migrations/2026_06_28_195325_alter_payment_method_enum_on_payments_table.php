<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE payments
            MODIFY payment_method ENUM(
                'cash',
                'bank_transfer',
                'vodafone_cash',
                'instapay',
                'card',
                'wallet'
            ) NOT NULL;
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE payments
            MODIFY payment_method ENUM(
                'cash',
                'bank_transfer',
                'vodafone_cash',
                'instapay',
                'card'
            ) NOT NULL;
        ");
    }
};
