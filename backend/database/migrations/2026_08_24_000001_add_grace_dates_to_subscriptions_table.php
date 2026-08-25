<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('grace_start_date')
                ->nullable()
                ->after('end_date');

            $table->date('grace_end_date')
                ->nullable()
                ->after('grace_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'grace_start_date',
                'grace_end_date',
            ]);
        });
    }
};
