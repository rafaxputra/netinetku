@php
    $user = Auth::user();
    $pelanggan = $user->pelanggan;
    $tagihan = \App\Models\Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'belum lunas')->first();
@endphp

@php
    use App\Models\Tagihan;
    $user = Auth::user();
    $pelanggan = $user->pelanggan;
    $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->where('status', 'belum lunas')->first();
@endphp

@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if ($pelanggan && $pelanggan->status === 'nonaktif')
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Akun Anda Dinonaktifkan</h4>
            <p>Akun Anda telah dinonaktifkan karena belum melakukan pembayaran tagihan. Silakan hubungi admin untuk mengaktifkan kembali akun Anda.</p>
            <a href="https://wa.me/6285175175105?text=Halo Admin, akun saya dengan ID {{ Auth::user()->id }} dan nama {{ Auth::user()->name }} telah dinonaktifkan, mohon bantuannya untuk diaktifkan kembali." class="btn btn-success">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </a>
        </div>
    @else


        <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <a href="https://www.speedtest.net/" target="_blank" class="text-decoration-none">
                            <i class="bi bi-speedometer2" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-3">Status Koneksi</h5>
                            <p class="card-text">Lihat status koneksi Anda</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar" style="font-size: 2rem;"></i>
                        <h5 class="card-title mt-3">Tanggal Hari Ini</h5>
                        <p class="card-text">{{ date('d F Y') }}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <a href="{{ route('tagihan2.index') }}" class="text-decoration-none">
                            <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-3">Tagihan</h5>
                            <p class="card-text">Lihat tagihan Anda</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <a href="{{ route('profil.index', ['id' => Auth::user()->pelanggan->id]) }}" class="text-decoration-none">
                            <i class="bi bi-person" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-3">Profil</h5>
                            <p class="card-text">Lihat profil Anda</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card glass-effect">
                    <div class="card-body text-center">
                        <a href="{{ route('paket2.index') }}" class="text-decoration-none">
                            <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-3">Paket Layanan</h5>
                            <p class="card-text">Paket Layanan</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if ($tagihan)
            <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Segera Bayar Tagihan Anda</h4>
            <p>Anda memiliki tagihan yang belum lunas. Silakan segera melakukan pembayaran.</p>
            <a href="{{ route('tagihan2.index') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-text"></i> Lihat Tagihan
            </a>
        </div>
        @endif
    @endif
</div>
@endsection
