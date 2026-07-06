<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ⚠️ DUMMY SEMENTARA — tabel asli tanggung jawab Anggota 2 (SIM Dokter & Pegawai).
 * Sama seperti tabel pasien, ganti/sesuaikan setelah versi final ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('spesialisasi')->nullable();
            $table->string('no_str')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
