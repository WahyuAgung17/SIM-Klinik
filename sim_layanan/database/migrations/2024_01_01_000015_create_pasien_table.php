<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ⚠️ DUMMY SEMENTARA — tabel asli tanggung jawab Anggota 1 (SIM Pasien).
 * Struktur di sini dibuat sesederhana mungkin agar modul Kunjungan &
 * Pemeriksaan bisa langsung dites. Kalau versi final dari Anggota 1 sudah
 * ada, migration & model ini tinggal dihapus/diganti — sesuaikan juga
 * nama kolom yang dipakai di KunjunganController & view jika berbeda.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nama');
            $table->string('nik', 20)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
