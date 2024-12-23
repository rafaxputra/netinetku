<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    // Menampilkan semua tagihan
    public function index(Request $request)
    {
        $query = Tagihan::join('tb_pelanggan', 'tb_tagihan.pelanggan_id', '=', 'tb_pelanggan.id')
                        ->join('users', 'tb_pelanggan.user_id', '=', 'users.id')
                        ->select('tb_tagihan.*', 'users.name as pelanggan_name', 'tb_pelanggan.no_hp as pelanggan_phone', 'tb_tagihan.tanggal as tanggal')
                        ->when(request('status') && request('status') != 'semua', function ($query) {
                            $query->where('tb_tagihan.status', request('status'));
                        });

        if ($request->has('cari')) {
            $search = $request->input('cari');
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                  ->orWhere('tb_tagihan.tanggal', 'LIKE', "%{$search}%");
            });
        }

        $tagihans = $query->paginate(10);
        return view('tagihan.index', compact('tagihans'));
    }

    // Menampilkan detail tagihan berdasarkan ID
    public function show($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        return view('tagihan.show', compact('tagihan'));
    }

    // Menampilkan form untuk membuat tagihan baru
    public function create()
    {
        $pelanggans = Pelanggan::join('users', 'tb_pelanggan.user_id', '=', 'users.id')
                                ->select('tb_pelanggan.id', 'users.name')
                                ->get();
        return view('tagihan.create', compact('pelanggans'));
    }

    // Menyimpan tagihan baru
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        $request->validate([
            'pelanggan_id' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        $request->merge(['status' => 'belum lunas']);

        dd($request->all());
        Tagihan::create($request->except('bulan'));

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit tagihan
    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        return view('tagihan.edit', compact('tagihan'));
    }

    // Mengupdate tagihan berdasarkan ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|integer',
            'tanggal' => 'required|date',
            'status' => 'required|in:lunas,belum lunas',
        ]);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update($request->except('bulan'));

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diupdate.');
    }

    // Menghapus tagihan berdasarkan ID
    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }


    // Memverifikasi tagihan berdasarkan ID
    public function verify($id)
    {
        DB::transaction(function () use ($id) {
            $tagihan = Tagihan::findOrFail($id);
            if ($tagihan->status === 'lunas') {
                return redirect()->route('tagihan.index')->with('info', 'Tagihan ini sudah lunas.');
            }

            // Mengubah status tagihan menjadi lunas
            $tagihan->status = 'lunas';
            $tagihan->save();

            // Mendapatkan informasi pelanggan dan harga paket
            $pelanggan = Pelanggan::findOrFail($tagihan->pelanggan_id);
            $harga_paket = DB::table('tb_paket')->where('id', $pelanggan->paket_id)->value('harga');

            // Menyimpan informasi pembayaran ke tabel tb_pembayaran
            Pembayaran::create([
                'pelanggan_id' => $tagihan->pelanggan_id,
                'tagihan_id' => $tagihan->id,
                'jumlah_pembayaran' => $harga_paket,
                'tanggal_pembayaran' => now(),
            ]);
        });

        return redirect()->route('tagihan.index')->with('success', 'Status tagihan berhasil diubah menjadi lunas dan informasi pembayaran telah disimpan.');
    }
}
