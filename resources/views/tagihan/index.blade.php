@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Daftar Tagihan</h1>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info" role="alert">
            {{ session('info') }}
        </div>
    @endif
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <form action="{{ route('tagihan.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari ...." value="{{ request('cari') }}" maxlength="255" autocomplete="off">
                <select name="status" class="form-control">
                    <option value="semua">Semua</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum lunas" {{ request('status') == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari & Filter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = ($tagihans->currentPage() - 1) * $tagihans->perPage() + 1;
                @endphp
                @foreach($tagihans as $tagihan)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $tagihan->pelanggan_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @if($tagihan->status === 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-warning">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if($tagihan->status === 'lunas')
                            <a href="{{ route('tagihan.cetak', $tagihan->id) }}" class="btn btn-success" target="_blank">
                                <i class="bi bi-printer-fill"></i> Cetak Struk
                            </a>
                        @else
                            <form action="{{ route('tagihan.verify', $tagihan->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Verifikasi</button>
                            </form>
                            <a href="https://wa.me/{{ $tagihan->pelanggan_phone }}?text=Waktunya%20untuk%20membayar%20tagihan" class="btn btn-success">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        @if ($tagihans->currentPage() == 1)
            <span class="btn btn-secondary disabled mr-2">Previous</span>
        @else
            <a href="{{ route('tagihan.index', array_merge(request()->query(), ['page' => $tagihans->currentPage() - 1])) }}" class="btn btn-secondary mr-2">Previous</a>
        @endif

        @if ($tagihans->hasMorePages())
            <a href="{{ route('tagihan.index', array_merge(request()->query(), ['page' => $tagihans->currentPage() + 1])) }}" class="btn btn-primary">Next</a>
        @else
            <span class="btn btn-primary disabled">Next</span>
        @endif
    </div>
</div>
@endsection
