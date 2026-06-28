<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('device_type', ['onu', 'router', 'mikrotik', 'switch', 'olt']);
            $table->string('brand');
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['active', 'inactive', 'faulty', 'returned'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
