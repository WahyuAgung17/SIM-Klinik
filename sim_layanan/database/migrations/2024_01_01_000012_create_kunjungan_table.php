<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PENTING: migration ini butuh tabel `pasien` (Anggota 1) dan `dokter`
     * (Anggota 2) sudah ada lebih dulu. Koordinasikan timestamp nama file
     * migration supaya urutannya benar saat `php artisan migrate` dijalankan
     * bersama-sama satu tim.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('no_kunjungan')->unique();
            //$table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->unsignedBigInteger('pasien_id'); //sementara
            $table->foreignId('poli_id')->constrained('poli');
            //$table->foreignId('dokter_id')->constrained('dokter');
            $table->unsignedBigInteger('dokter_id'); //sementara
            $table->dateTime('tanggal_kunjungan');
            $table->text('keluhan')->nullable();
            $table->enum('status_kunjungan', [
                'terdaftar',
                'menunggu_pemeriksaan',
                'sedang_diperiksa',
                'selesai_diperiksa',
                'menunggu_pembayaran',
                'selesai',
            ])->default('terdaftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
