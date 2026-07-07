<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('sikeu')->create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nim');
            $table->string('periode', 50);
            $table->unsignedBigInteger('total_tagihan');
            $table->string('status_bayar', 30)->default('Belum Lunas');
            $table->string('order_id')->nullable()->unique();
            $table->text('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('nim');
            $table->index('status_bayar');
        });
    }

    public function down(): void
    {
        Schema::connection('sikeu')->dropIfExists('tagihan');
    }
};
