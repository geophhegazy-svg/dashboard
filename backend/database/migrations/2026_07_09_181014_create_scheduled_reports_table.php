<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_reports', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('report_name');

            $table->string('frequency');

            $table->string('format', 20)->default('csv');

            $table->json('filters')->nullable();

            $table->string('email')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamp('last_run_at')->nullable();

            $table->timestamp('next_run_at')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('report_name');
            $table->index('frequency');
            $table->index('is_active');
            $table->index('next_run_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_reports');
    }
};
