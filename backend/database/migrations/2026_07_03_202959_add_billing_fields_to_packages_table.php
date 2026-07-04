<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {

            $table->string('billing_cycle')
                ->default('month')
                ->after('price');

            $table->unsignedSmallInteger('billing_interval')
                ->default(1)
                ->after('billing_cycle');

            $table->unsignedSmallInteger('grace_days')
                ->default(0)
                ->after('billing_interval');

            $table->boolean('auto_suspend')
                ->default(true)
                ->after('grace_days');

            $table->boolean('auto_expire')
                ->default(true)
                ->after('auto_suspend');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {

            $table->dropColumn([
                'billing_cycle',
                'billing_interval',
                'grace_days',
                'auto_suspend',
                'auto_expire',
            ]);
        });
    }
};
