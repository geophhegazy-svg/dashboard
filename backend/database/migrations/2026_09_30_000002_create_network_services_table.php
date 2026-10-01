<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('network_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();

            $table->foreignId('package_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('network_device_id')
                ->nullable()
                ->constrained('network_devices')
                ->nullOnDelete();

            $table->enum('connection_type', ['pppoe', 'hotspot']);

            $table->string('username');
            $table->string('password')->nullable();

            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();

            $table->enum('ip_mode', ['dynamic', 'static'])
                ->default('dynamic');

            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();

            $table->enum('status', [
                'pending',
                'active',
                'suspended',
                'expired',
                'cancelled',
            ])->default('pending');

            $table->enum('provisioning_status', [
                'pending',
                'provisioning',
                'provisioned',
                'failed',
                'drifted',
            ])->default('pending');

            $table->dateTime('last_provisioned_at')->nullable();
            $table->dateTime('last_sync_at')->nullable();
            $table->text('last_error')->nullable();

            $table->timestamps();

            $table->index(['tenant_id', 'customer_id']);
            $table->index(['tenant_id', 'area_id']);
            $table->index(['tenant_id', 'package_id']);
            $table->index(['tenant_id', 'network_device_id']);
            $table->index(['tenant_id', 'connection_type']);
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'provisioning_status']);
            $table->index(['tenant_id', 'username']);
            $table->index(['tenant_id', 'mac_address']);
            $table->index(['tenant_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('network_services');
    }
};
