<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->cascadeOnDelete();
           // $table->foreignId('dokter_id')->constrained('dokter');
            $table->unsignedBigInteger('dokter_id'); //sementara
            $table->text('diagnosa')->nullable();
            $table->text('catatan_pemeriksaan')->nullable();
            $table->text('resep')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
