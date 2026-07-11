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
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel dokters
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            
            // Status jadwal dokter
            $table->enum('status', ['tersedia', 'penuh', 'tutup'])->default('tersedia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokters');
    }
};