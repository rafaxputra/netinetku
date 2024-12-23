@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card glass-effect">
        <div class="card-header">
            <i class="bi bi-pencil-fill"></i> Edit Paket Layanan Internet
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('paket.update', $paket->id) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="nama_paket" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" maxlength="255" autocomplete="off" required>
                    @error('nama_paket')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kecepatan" class="form-label">Kecepatan (Mbps)</label>
                    <input type="number" class="form-control" id="kecepatan" name="kecepatan" value="{{ old('kecepatan', $paket->kecepatan) }}" maxlength="10" min="1" required>
                    @error('kecepatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
<input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $paket->harga) }}" maxlength="10" pattern="[0-9]+([.,][0-9]+)?" required>
                    @error('harga')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Perbarui
                </button>
                <a href="{{ route('paket.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
