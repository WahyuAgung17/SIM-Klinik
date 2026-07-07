<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama');
            $table->unsignedTinyInteger('sks');
            $table->unsignedTinyInteger('semester');
            $table->unsignedTinyInteger('id_prodi');
            $table->unsignedBigInteger('dosen_pengampu_id')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();

            $table->index('id_prodi');
            $table->index('dosen_pengampu_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
