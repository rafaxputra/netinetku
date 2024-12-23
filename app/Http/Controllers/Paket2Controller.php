<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class Paket2Controller extends Controller
{
    /**
     * Menampilkan daftar paket dengan pencarian dan pagination.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Menangani pencarian paket
        $query = Paket::query();

        // Jika ada query pencarian dari input pengguna
        if ($request->has('cari') && $request->cari != '') {
            // Pencarian berdasarkan nama paket
            $query->where('nama_paket', 'like', '%' . $request->cari . '%');
        }

        // Ambil data paket dengan pagination
        $pakets = $query->paginate(9); // Ambil 9 paket per halaman

        // Kirim data ke view dengan compact
        return view('paket2.index', compact('pakets'));
    }

    /**
     * Fungsi untuk menangani aksi ganti paket.
     * Mengarahkan pengguna ke WhatsApp untuk mengonfirmasi perubahan paket.
     *
     * @param int $paketId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function gantiPaket($paketId)
    {
        // Ambil data paket berdasarkan ID
        $paket = Paket::findOrFail($paketId);

        // Mendapatkan data pelanggan (asumsi menggunakan sistem autentikasi Laravel)
        $idPelanggan = auth()->user()->id; // ID pelanggan yang login
        $namaPelanggan = auth()->user()->name; // Nama pelanggan yang login

        // Membuat pesan WhatsApp
        $pesan = "Halo, saya $namaPelanggan (ID Pelanggan: $idPelanggan). Saya ingin mengganti paket saya ke paket $paket->nama_paket.";

        // Nomor WhatsApp tujuan
        $nomorWhatsApp = '6281456090185';

        // Membuat URL WhatsApp
        $urlWhatsApp = "https://wa.me/$nomorWhatsApp?text=" . urlencode($pesan);

        // Arahkan pengguna ke WhatsApp
        return redirect($urlWhatsApp);
    }
}
