<?php

declare(strict_types=1);

use App\Enums\AccountNature;
use App\Enums\AccountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete();

            $table->string('code', 20);

            $table->string('name');

            $table->enum('type', AccountType::values());

            $table->enum('nature', AccountNature::values());

            $table->unsignedTinyInteger('level')
                ->default(1);

            $table->boolean('is_system')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->text('description')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'tenant_id',
                'code'
            ]);

            $table->index([
                'tenant_id',
                'parent_id'
            ]);

            $table->index([
                'tenant_id',
                'type'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
