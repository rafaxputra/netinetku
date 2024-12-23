<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_paket')->insert([
            'nama_paket' => 'Paket murah',
            'kecepatan' => 10,
            'harga' => 150000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_paket')->insert([
            'nama_paket' => 'Paket normal',
            'kecepatan' => 30,
            'harga' => 250000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tb_paket')->insert([
            'nama_paket' => 'Paket panas',
            'kecepatan' => 50,
            'harga' => 500000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
