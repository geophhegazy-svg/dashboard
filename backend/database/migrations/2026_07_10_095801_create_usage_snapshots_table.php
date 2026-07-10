<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usage_snapshots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 'pppoe' أو 'hotspot'
            $table->string('connection_type');

            // اسم المستخدم على الراوتر وقت أخذ اللقطة (لو المستخدم اتغير بعدين)
            $table->string('username');

            // القراءة التراكمية الخام من الراوتر وقت أخذ اللقطة
            $table->unsignedBigInteger('bytes_download')->default(0);
            $table->unsignedBigInteger('bytes_upload')->default(0);

            $table->timestamp('recorded_at');

            $table->timestamps();

            $table->index(['customer_id', 'connection_type', 'recorded_at']);
            $table->index(['username', 'connection_type', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_snapshots');
    }
};
