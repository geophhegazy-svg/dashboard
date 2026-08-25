<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->enum('status', [
                    'draft',
                    'pending',
                    'active',
                    'grace',
                    'suspended',
                    'expired',
                    'cancelled',
                    'terminated',
                ])->default('active')->change();
            });

            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->enum('status', [
                    'active',
                    'expired',
                    'suspended',
                ])->default('active')->change();
            });

            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });
    }
};
