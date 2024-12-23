<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPelanggan = \DB::table('tb_pelanggan')->count();
        $pendapatanBulanan = \DB::table('tb_pembayaran')
            ->select('tanggal_pembayaran', DB::raw('SUM(jumlah_pembayaran) as pendapatan'))
            ->groupBy('tanggal_pembayaran')
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'bulan' => Carbon::parse($item->tanggal_pembayaran)->format('M Y'),
                    'pendapatan' => $item->pendapatan,
                ];
            });

        $pendapatanBulanIni = \DB::table('tb_pembayaran')
            ->selectRaw('SUM(jumlah_pembayaran) as pendapatan')
            ->whereMonth('tanggal_pembayaran', Carbon::now()->month)
            ->whereYear('tanggal_pembayaran', Carbon::now()->year)
            ->first();

        $user = Auth::user();
        $tagihanBelumLunas = [];
        $message = null;

        if ($user->role === 'admin' || $user->role === 'pelanggan' || $user->role === 'owner') {
            $tagihanBelumLunas = Tagihan::join('tb_pelanggan', 'tb_tagihan.pelanggan_id', '=', 'tb_pelanggan.id')
                ->join('tb_paket', 'tb_pelanggan.paket_id', '=', 'tb_paket.id')
                ->where('tb_pelanggan.user_id', $user->id)
                ->where('tb_tagihan.status', 'belum lunas')
                 ->where('tb_tagihan.tanggal', Carbon::now()->format('Y-m-d'))
                ->select('tb_tagihan.*', 'tb_paket.harga as harga_paket')
                ->orderBy('tb_tagihan.created_at', 'desc')
                ->get()
                ->map(function ($tagihan) {
                    $tagihan->jumlah = $tagihan->harga_paket;
                    return $tagihan;
                });
        }


        if ($user->role === 'admin' || $user->role === 'owner') {
            return view('dashboard.admin', [
                'tagihanBelumLunas' => $tagihanBelumLunas,
                'jumlahPelanggan' => $jumlahPelanggan,
                'pendapatanBulanan' => $pendapatanBulanan,
                'pendapatanBulanIni' => $pendapatanBulanIni,
            ]);
        } elseif ($user->role === 'pelanggan') {
            return view('dashboard.pelanggan', [
                'tagihanBelumLunas' => $tagihanBelumLunas,
                'message' => $message,
            ]);
        }

        // Fallback for other roles or unauthenticated users
        return view('welcome');
    }
}
