<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('network_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('type')->default('mikrotik');
            $table->integer('port')->default(8728);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_online')->default(false);
            $table->timestamp('last_ping_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();
            $table->text('last_error')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('network_devices');
    }
};
