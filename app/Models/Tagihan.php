<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tagihan extends Model
{
    protected $table = 'tb_tagihan';
    protected $fillable = ['pelanggan_id', 'tanggal', 'status', 'jumlah', 'keterangan'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function paket()
    {
        return $this->hasOneThrough(Paket::class, Pelanggan::class, 'id', 'id', 'pelanggan_id', 'paket_id');
    }
}
