<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen_wali_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->unique()->constrained('mahasiswa')->cascadeOnDelete();
            $table->unsignedBigInteger('dosen_wali_id')->nullable();
            $table->timestamps();

            $table->index('dosen_wali_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_wali_mahasiswa');
    }
};
