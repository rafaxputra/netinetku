@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card glass-effect">
        <div class="card-header">
            <i class="bi bi-person"></i> Data Diri Pelanggan
        </div>
        <div class="card-body">
            <!-- Tabel Data -->
            <table class="table table-striped table-bordered">
                <tbody>
                    <!-- Nama -->
                    <tr>
                        <th scope="row" style="color: #fff;">Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <!-- Email -->
                    <tr>
                        <th scope="row" style="color: #fff;">Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <!-- Alamat -->
                    <tr>
                        <th scope="row" style="color: #fff;">Alamat</th>
                        <td>{{ $pelanggan->alamat }}</td>
                    </tr>
                    <!-- No. HP -->
                    <tr>
                        <th scope="row" style="color: #fff;">No. HP</th>
                        <td>{{ $pelanggan->no_hp }}</td>
                    </tr>
                    <!-- Tanggal Pendaftaran -->
                    <tr>
                        <th scope="row" style="color: #fff;">Tanggal Pendaftaran</th>
                        <td>{{ \Carbon\Carbon::parse($pelanggan->tanggal_pendaftaran)->format('d M Y') }}</td>
                    </tr>
                    <!-- Paket -->
                    <tr>
                        <th scope="row" style="color: #fff;">Paket</th>
                        <td>{{ $pelanggan->paket->nama_paket ?? 'Tidak ada paket' }}</td>
                    </tr>
                    <!-- Status -->
                    <tr>
                        <th scope="row" style="color: #fff;">Status</th>
                        <td>{{ ucfirst($pelanggan->status) }}</td>
                    </tr>
                </tbody>
            </table>


            <!-- Tombol Kembali -->
            <a href="/dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Tombol Ubah Data -->
            <a href="https://wa.me/6281252616127?text=Halo%20admin!%20Saya%20{{ urlencode($user->name) }}%20(id%20pelanggan%3A%20{{ $user->id }})%20ingin%20mengubah%20data%20pelanggan%20saya."
                class="btn btn-primary ms-2" target="_blank">
                <i class="bi bi-pencil-square"></i> Ubah Data
            </a>

        </div>
    </div>
</div>
@endsection