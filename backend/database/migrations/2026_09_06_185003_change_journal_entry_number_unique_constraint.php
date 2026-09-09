<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal_entries', function (Blueprint $table): void {
            $table->dropUnique('journal_entries_entry_number_unique');

            $table->unique(
                ['tenant_id', 'entry_number'],
                'journal_entries_tenant_entry_number_unique',
            );
        });
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table): void {
            $table->dropUnique(
                'journal_entries_tenant_entry_number_unique',
            );

            $table->unique(
                'entry_number',
                'journal_entries_entry_number_unique',
            );
        });
    }
};
