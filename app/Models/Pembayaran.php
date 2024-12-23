<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pembayaran extends Model
{
    protected $table = 'tb_pembayaran'; // Nama tabel

    protected $fillable = [
        'pelanggan_id',
        'tagihan_id',
        'jumlah_pembayaran',
        'tanggal_pembayaran'
    ];
}

class CreateTbPembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('tagihan_id');
            $table->decimal('jumlah_pembayaran', 10, 2);
            $table->timestamp('tanggal_pembayaran');
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('tb_pelanggan')->onDelete('cascade');
            $table->foreign('tagihan_id')->references('id')->on('tb_tagihan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_pembayaran');
    }
}