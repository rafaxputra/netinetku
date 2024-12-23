<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PaketSeeder::class,
        ]);

        \App\Models\User::create([
            'name' => 'rizky',
            'email' => 'rizky@gmail.com',
            'password' => Hash::make('11223344'),
            'role' => 'owner',
        ]);

        \App\Models\User::create([
            'name' => 'natasya',
            'email' => 'natasya@gmail.com',
            'password' => Hash::make('11223344'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'rafa',
            'email' => 'rafa@gmail.com',
            'password' => Hash::make('11223344'),
            'role' => 'pelanggan',
        ]);

    }
}
