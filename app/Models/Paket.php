<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Paket extends Model
{
    //
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tb_paket';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_paket',
        'kecepatan',
        'harga',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'paket_id');
    }
}
