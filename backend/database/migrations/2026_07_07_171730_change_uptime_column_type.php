<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspot_users', function (Blueprint $table) {
            // تغيير type إلى string مع الاحتفاظ بالقيم الرقمية
            $table->string('uptime', 50)->default('0')->change();
        });
    }

    public function down(): void
    {
        Schema::table('hotspot_users', function (Blueprint $table) {
            $table->integer('uptime')->default(0)->change();
        });
    }
};
