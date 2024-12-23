@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Tambah Paket Layanan Internet</h1>
    <form action="{{ route('paket.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_paket">Nama Paket</label>
            <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" maxlength="255" autocomplete="off" required>
            @error('nama_paket')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kecepatan">Kecepatan (Mbps)</label>
            <input type="number" class="form-control @error('kecepatan') is-invalid @enderror" id="kecepatan" name="kecepatan" value="{{ old('kecepatan') }}" maxlength="10" min="1" required>
            @error('kecepatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" required min="1000" max="10000000" step="1000" maxlength="10">
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Harga harus antara Rp 1.000 hingga Rp 10.000.000</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Paket</button>
    </form>
</div>

@endsection
