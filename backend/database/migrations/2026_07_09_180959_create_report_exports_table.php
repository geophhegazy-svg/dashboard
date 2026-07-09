<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_exports', function (Blueprint $table) {

            $table->id();

            $table->foreignId('report_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('format', 20);

            $table->string('filename');

            $table->string('disk')->default('local');

            $table->string('path');

            $table->string('mime_type');

            $table->unsignedBigInteger('size')->default(0);

            $table->foreignId('exported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('exported_at')->nullable();

            $table->timestamps();

            $table->index('format');
            $table->index('exported_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_exports');
    }
};
