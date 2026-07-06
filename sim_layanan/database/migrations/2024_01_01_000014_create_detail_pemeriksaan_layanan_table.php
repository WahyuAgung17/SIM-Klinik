<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemeriksaan_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaan')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('jumlah')->default(1);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemeriksaan_layanan');
    }
};
