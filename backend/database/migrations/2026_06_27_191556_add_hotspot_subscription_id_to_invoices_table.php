<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->foreignId('hotspot_subscription_id')
                ->nullable()
                ->after('subscription_id')
                ->constrained('hotspot_subscriptions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->dropForeign([
                'hotspot_subscription_id'
            ]);

            $table->dropColumn(
                'hotspot_subscription_id'
            );
        });
    }
};
