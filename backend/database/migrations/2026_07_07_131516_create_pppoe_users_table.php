<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pppoe_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->foreignId('mikrotik_device_id')->nullable()->constrained('network_devices')->nullOnDelete();
            $table->string('profile')->nullable();
            $table->string('queue')->nullable();
            $table->enum('status', ['active', 'disabled', 'expired'])->default('active');
            $table->boolean('is_online')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // فهارس للبحث السريع
            $table->index('username');
            $table->index('status');
            $table->index('is_online');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pppoe_users');
    }
};
