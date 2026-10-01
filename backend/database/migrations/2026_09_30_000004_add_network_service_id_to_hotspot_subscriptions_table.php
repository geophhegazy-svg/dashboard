<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspot_subscriptions', function (Blueprint $table) {
            $table->foreignId('network_service_id')
                ->nullable()
                ->after('package_id')
                ->constrained('network_services')
                ->nullOnDelete();

            $table->index(['tenant_id', 'network_service_id']);
        });
    }

    public function down(): void
    {
        Schema::table('hotspot_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['network_service_id']);
            $table->dropIndex(['tenant_id', 'network_service_id']);
            $table->dropColumn('network_service_id');
        });
    }
};
