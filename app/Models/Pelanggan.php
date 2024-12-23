<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'paket_id', 'alamat', 'no_hp', 'tanggal_pendaftaran','status'];
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    // Jika Anda ingin mengatur format tanggal secara otomatis
    protected $dates = [
        'tanggal_pendaftaran'
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pelanggan_id');
    }
}
