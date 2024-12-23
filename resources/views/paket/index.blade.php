@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Menambahkan margin-bottom yang lebih besar pada judul -->
    <h1 class="text-center mb-5">Daftar Paket Layanan Internet</h1>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form pencarian paket dan tombol tambah paket dalam satu baris, dengan posisi terbalik -->
    <div class="d-flex justify-content-between mb-3">
        <!-- Tombol Tambah Paket Baru untuk Admin -->
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('paket.create') }}" class="btn btn-success">Tambah Paket Baru</a>
        @endif

        <!-- Form pencarian paket -->
        <form action="{{ route('paket.index') }}" method="GET" class="form-inline">
            <input type="text" name="cari" class="form-control mr-sm-2" value="{{ request('cari') }}" placeholder="Cari Paket" maxlength="255" autocomplete="off">
            <button type="submit" class="btn btn-primary my-2 my-sm-0">Cari</button>
        </form>
    </div>

    <!-- Menambahkan jarak antara tabel dan tombol dengan margin-top -->
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Paket</th>
                    <th>Kecepatan</th>
                    <th>Harga</th>
                    @if(auth()->user()->role == 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $i = ($pakets->currentPage() - 1) * $pakets->perPage() + 1;
                @endphp
                @foreach($pakets as $paket)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ $paket->kecepatan }} Mbps</td>
                        <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>

                        <!-- Aksi Edit dan Hapus untuk admin -->
                        @if(auth()->user()->role == 'admin')
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('paket.edit', $paket->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('paket.destroy', $paket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
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
