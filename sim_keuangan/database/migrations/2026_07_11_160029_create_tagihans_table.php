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
    Schema::create('tagihans', function (Blueprint $table) {
        $table->id();
        $table->string('no_tagihan')->unique();
        $table->integer('kunjungan_id'); 
        $table->integer('total_tagihan');
        $table->enum('status_pembayaran', ['Belum Dibayar', 'Menunggu Pembayaran', 'Berhasil Dibayar', 'Gagal', 'Kadaluarsa', 'Dibatalkan']);
        $table->string('metode_pembayaran')->nullable();
        $table->string('snap_token')->nullable();
        $table->string('midtrans_order_id')->nullable();
        $table->timestamp('tanggal_tagihan');
        $table->timestamp('tanggal_bayar')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
