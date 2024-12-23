<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
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
        $pakets = $query->paginate(10);

        // Kirim data ke view dengan compact
        return view('paket.index', compact('pakets'));
    }

    /**
     * Menampilkan form untuk menambah paket baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('paket.create');
    }

    /**
     * Menyimpan paket baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kecepatan' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Simpan paket baru
        Paket::create($request->all());

        // Redirect kembali dengan pesan sukses
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit paket.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Ambil data paket berdasarkan ID
        $paket = Paket::findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

    /**
     * Memperbarui data paket di database.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kecepatan' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Update data paket
        $paket = Paket::findOrFail($id);
        $paket->update($request->all());

        // Redirect kembali dengan pesan sukses
        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    /**
     * Menghapus paket dari database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Hapus paket berdasarkan ID
        $paket = Paket::findOrFail($id);
        $paket->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus');
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
        $nomorWhatsApp = '081456090185';

        // Membuat URL WhatsApp
        $urlWhatsApp = "https://wa.me/$nomorWhatsApp?text=" . urlencode($pesan);

        // Arahkan pengguna ke WhatsApp
        return redirect($urlWhatsApp);
    }
}
