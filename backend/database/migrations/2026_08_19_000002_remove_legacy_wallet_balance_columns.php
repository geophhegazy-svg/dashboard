<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('subscriptions', 'wallet_balance')) {
            Schema::table('subscriptions', function (Blueprint $table): void {
                $table->dropColumn('wallet_balance');
            });
        }

        if (Schema::hasColumn('hotspot_subscriptions', 'wallet_balance')) {
            Schema::table('hotspot_subscriptions', function (Blueprint $table): void {
                $table->dropColumn('wallet_balance');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('subscriptions', 'wallet_balance')) {
            Schema::table('subscriptions', function (Blueprint $table): void {
                $table->decimal('wallet_balance', 10, 2)
                    ->default(0)
                    ->after('monthly_price');
            });
        }

        if (! Schema::hasColumn('hotspot_subscriptions', 'wallet_balance')) {
            Schema::table('hotspot_subscriptions', function (Blueprint $table): void {
                $table->decimal('wallet_balance', 10, 2)
                    ->default(0)
                    ->after('monthly_price');
            });
        }
    }
};
