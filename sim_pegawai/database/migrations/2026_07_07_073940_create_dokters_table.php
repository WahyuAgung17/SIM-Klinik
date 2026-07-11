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
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel polis
            $table->foreignId('poli_id')->constrained('polis');
            
            $table->string('nama_dokter');
            $table->string('kode_dokter')->unique();
            $table->string('spesialisasi');
            $table->string('no_hp');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};