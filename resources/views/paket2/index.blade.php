@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Daftar Paket</h1>

    <!-- Form Pencarian -->
    <form action="{{ route('paket2.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari Paket..." name="cari" value="{{ request('cari') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        @foreach($pakets as $paket)
            <div class="col-md-4 mb-4">
                <!-- Card dengan glass effect, rounded corners, dan hover effect -->
                <div class="card">
                    <div class="card-body">
                        <!-- Nama Paket -->
                        <h5 class="card-title">{{ $paket->nama_paket }}</h5>
                        <!-- Kecepatan Paket -->
                        <p class="card-text">Kecepatan: {{ $paket->kecepatan }} Mbps</p>
                        <!-- Harga Paket -->
                        <p class="card-text">Harga: Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>

                        <!-- Tombol Ganti Paket dengan Ikon Bootstrap -->
                        <a href="{{ route('paket2.ganti', $paket->id) }}" class="btn btn-primary">
                            <i class="bi bi-arrow-right-circle"></i> Ganti Paket
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        @if ($pakets->currentPage() == 1)
            <span class="btn btn-secondary disabled mr-2">Previous</span>
        @else
            <a href="{{ $pakets->previousPageUrl() }}" class="btn btn-secondary mr-2">Previous</a>
        @endif

        @if ($pakets->hasMorePages())
            <a href="{{ $pakets->nextPageUrl() }}" class="btn btn-primary">Next</a>
        @else
            <span class="btn btn-primary disabled">Next</span>
        @endif
    </div>
</div>
@endsection
