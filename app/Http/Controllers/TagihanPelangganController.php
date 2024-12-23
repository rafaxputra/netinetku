<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class TagihanPelangganController extends Controller
{
    // Menampilkan semua tagihan untuk pelanggan yang sedang login
    public function index()
    {
        if (Auth::user()->role !== 'pelanggan') {
            return response()->view('errors.unauthorized', [], 403);
        }

        $user_id = Auth::id();
        $tagihans = Tagihan::join('tb_pelanggan', 'tb_tagihan.pelanggan_id', '=', 'tb_pelanggan.id')
                            ->where('tb_pelanggan.user_id', $user_id)
                            ->when(request('status') && request('status') != 'semua', function ($query) {
                                $query->where('tb_tagihan.status', request('status'));
                            })
                            ->select('tb_tagihan.*', 'tb_tagihan.tanggal')
                            ->paginate(10);
        
        return view('tagihan2.index', ['tagihans' => $tagihans]);
    }

    public function cetakStruk(Request $request, $id)
    {
        $tagihan = Tagihan::with('paket', 'pelanggan.user')->findOrFail($id);
    
        if ($tagihan->status !== 'lunas') {
            return redirect()->back()->with('error', 'Tagihan belum lunas, tidak dapat mencetak struk.');
        }
    
        $pembayaran = \App\Models\Pembayaran::where('tagihan_id', $tagihan->id)->first();

        if (!$tagihan->pelanggan) {
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan untuk tagihan ini.');
        }

        if (!$tagihan->pelanggan->user) {
            return redirect()->back()->with('error', 'User tidak ditemukan untuk pelanggan ini.');
        }

        if (!$tagihan->pelanggan->paket) {
            return redirect()->back()->with('error', 'Paket tidak ditemukan untuk pelanggan ini.');
        }

        $data = [
            'tagihan' => $tagihan,
            'pelanggan' => $tagihan->pelanggan,
            'paket' => $tagihan->pelanggan->paket,
            'tanggal' => Carbon::parse($tagihan->tanggal)->format('d-m-Y'),
            'admin' => $request->query('admin'),
            'pembayaran' => $pembayaran,
        ];
    
        $pdf = PDF::loadView('pdf.struk-tagihan', $data);
        return $pdf->download("struk-tagihan-{$tagihan->id}.pdf");
    }
    
}
