@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Daftar Pelanggan</h1>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <div class="d-flex">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary mb-2 mb-md-0 mr-2">
                        <i class="bi bi-person-plus-fill"></i> Tambah Pelanggan
                    </a>
                @endif
                @if(auth()->user()->role == 'owner')
                    <a href="{{ route('pelanggan.export.excel') }}" class="btn btn-success mb-2 mb-md-0">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                @endif
            @endauth
        </div>
        <form action="{{ route('pelanggan.index') }}" method="GET" class="form-inline">
            <input type="text" name="cari" class="form-control mr-sm-2" value="{{ request('cari') }}" placeholder="Cari Pengguna" maxlength="255" autocomplete="off">
            <button type="submit" class="btn btn-primary my-2 my-sm-0">Cari</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Tgl Daftar</th>
                    <th>Paket</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = ($users->currentPage() - 1) * $users->perPage() + 1;
                @endphp
                @foreach($users as $user)
                @if($user->pelanggan)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->pelanggan->alamat }}</td>
                    <td>{{ $user->pelanggan->no_hp }}</td>
                    <td>{{ $user->pelanggan->tanggal_pendaftaran }}</td>
                    <td>{{ $user->pelanggan->paket->nama_paket }}</td>
                    <td>{{ $user->pelanggan->status }}</td>
                    <td class="d-flex">
                        <a href="{{route('pelanggan.edit', $user->id)}}" class="btn btn-warning mr-2">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        @if ($users->currentPage() == 1)
            <span class="btn btn-secondary disabled mr-2">Previous</span>
        @else
            <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary mr-2">Previous</a>
        @endif

        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="btn btn-primary">Next</a>
        @else
            <span class="btn btn-primary disabled">Next</span>
        @endif
    </div>
</div>
@endsection
