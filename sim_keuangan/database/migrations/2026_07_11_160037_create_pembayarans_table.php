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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tagihan_id')->constrained('tagihans')->onDelete('cascade');
        $table->string('order_id');
        $table->string('payment_type')->nullable();
        $table->string('transaction_status')->nullable();
        $table->timestamp('transaction_time')->nullable();
        $table->integer('gross_amount')->nullable();
        $table->string('fraud_status')->nullable();
        $table->text('response_midtrans')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
