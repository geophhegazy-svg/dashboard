<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('title');

            $table->string('type', 30)->default('manual');

            $table->json('filters')->nullable();

            $table->string('status', 30)->default('completed');

            $table->foreignId('generated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('generated_at')->nullable();

            $table->timestamps();

            $table->index('name');
            $table->index('type');
            $table->index('status');
            $table->index('generated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
