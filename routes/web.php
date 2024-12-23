<?php

use App\Http\Controllers\ProfilPelangganController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\Paket2Controller;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TagihanPelangganController;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\PenggunaMiddleware;
use App\Http\Controllers\DashboardController;
use App\Models\Paket;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware([PenggunaMiddleware::class . ':owner'])->group(function () {
        Route::resource('pengguna', PenggunaController::class);
        Route::get('/pelanggan/export/excel', [PelangganController::class, 'exportExcel'])->name('pelanggan.export.excel');
    });
    
    Route::middleware([PenggunaMiddleware::class . ':owner,admin'])->group(function () {
        Route::resource('pelanggan', PelangganController::class);
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::middleware([PenggunaMiddleware::class . ':admin'])->group(function () {
        Route::resource('tagihan', TagihanController::class);
        Route::resource('paket', PaketController::class);
        Route::post('tagihan/{id}/verify', [TagihanController::class, 'verify'])->name('tagihan.verify');
        Route::get('tagihan/update-status', [TagihanController::class, 'updateStatus'])->name('tagihan.update-status');
    });

    Route::middleware([PenggunaMiddleware::class . ':pelanggan'])->group(function () {
        Route::get('tagihan2', [TagihanPelangganController::class, 'index'])->name('tagihan2.index');
        Route::get('/pelanggan/profil/{id}', [ProfilPelangganController::class, 'index'])->name('profil.index');
        Route::get('paket2', [Paket2Controller::class, 'index'])->name('paket2.index');
        Route::get('paket2/{paket}/ganti', [Paket2Controller::class, 'gantiPaket'])->name('paket2.ganti');
    });
    Route::get('/get-paket-harga/{paketId}', function ($paketId) { $harga = DB::table('tb_paket')->where('id', $paketId)->value('harga'); return response()->json(['harga' => $harga]); });
    Route::get('/get-pelanggan-paket/{pelangganId}', function ($pelangganId) {
        $paketId = DB::table('tb_pelanggan')->where('id', $pelangganId)->value('paket_id');
        return response()->json(['paket_id' => $paketId]);
    });
    Route::get('/tagihan/cetak-struk/{id}', [TagihanPelangganController::class, 'cetakStruk'])->name('tagihan.cetak');
});


Route::get('/inactive-notification', function () {
    return view('auth.inactive-notification');
})->name('inactive.notification');

require __DIR__.'/auth.php';
