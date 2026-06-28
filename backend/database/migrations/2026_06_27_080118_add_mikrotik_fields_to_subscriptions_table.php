<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {

            $table->string('pppoe_username')
                ->nullable()
                ->after('notes');

            $table->string('pppoe_password')
                ->nullable()
                ->after('pppoe_username');

            $table->string('mikrotik_profile')
                ->nullable()
                ->after('pppoe_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
        });
    }
};
