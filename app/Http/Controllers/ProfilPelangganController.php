<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilPelangganController extends Controller
{
    public function index($id)
    {
        // Validasi role pengguna sebagai pelanggan
        if (auth()->user()->role !== 'pelanggan') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data user dengan relasi ke Pelanggan dan Paket
        $user = User::with('pelanggan.paket')->findOrFail($id);

        // Pastikan hanya pelanggan yang sedang login dapat melihat datanya sendiri
        if (auth()->id() !== $user->id) {
            abort(403, 'Anda hanya dapat melihat data diri Anda sendiri.');
        }

        // Ambil data pelanggan dari relasi
        $pelanggan = $user->pelanggan;

        return view('pelanggan2.index', compact('user', 'pelanggan'));
    }
}
