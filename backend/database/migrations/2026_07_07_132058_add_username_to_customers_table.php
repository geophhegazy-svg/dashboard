<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // إضافة العمود فقط إذا لم يكن موجوداً
            if (!Schema::hasColumn('customers', 'username')) {
                $table->string('username')->nullable()->unique()->after('phone');
            }
            // التعليق على إضافة password لأنها موجودة بالفعل
            // if (!Schema::hasColumn('customers', 'password')) {
            //     $table->string('password')->nullable()->after('username');
            // }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
