<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('renewal_key')
                ->nullable()
                ->unique()
                ->after('invoice_number');
        });
    }


    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->dropUnique(['renewal_key']);

            $table->dropColumn('renewal_key');
        });
    }
};
