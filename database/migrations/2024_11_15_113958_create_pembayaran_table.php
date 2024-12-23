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
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('tb_pelanggan')->onDelete('cascade');
            $table->foreignId('tagihan_id')->constrained('tb_tagihan')->onDelete('cascade');
            $table->decimal('jumlah_pembayaran', 10, 2);
            $table->timestamp('tanggal_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembayaran');
    }
};
