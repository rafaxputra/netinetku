@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Daftar Tagihan Saya</h1>
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
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Paket</th>
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
                    <td>{{ $tagihan->created_at ? $tagihan->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ $tagihan->paket ? $tagihan->paket->nama_paket : 'Paket tidak ditemukan' }}</td>
                    <td>
                        @if($tagihan->status === 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-warning">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if($tagihan->status !== 'lunas')
                            <button class="btn btn-primary" onclick="showPaymentModal({{ $tagihan->id }}, '{{ $tagihan->created_at ? $tagihan->created_at->format('d-m-Y') : 'N/A'  }}', {{ $tagihan->paket ? $tagihan->paket->id : 'null' }})">
                                <i class="bi bi-credit-card-fill"></i> Bayar
                            </button>
                        @else
                            <a href="{{ route('tagihan.cetak', $tagihan->id) }}" class="btn btn-success" target="_blank">
                                <i class="bi bi-printer-fill"></i> Cetak Struk
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('tagihan2.index') }}" method="GET" class="mb-4">
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
    <div class="d-flex justify-content-center">
        @if ($tagihans->currentPage() == 1)
            <span class="btn btn-secondary disabled mr-2">Previous</span>
        @else
            <a href="{{ route('tagihan2.index', array_merge(request()->query(), ['page' => $tagihans->currentPage() - 1])) }}" class="btn btn-secondary mr-2">Previous</a>
        @endif

        @if ($tagihans->hasMorePages())
            <a href="{{ route('tagihan2.index', array_merge(request()->query(), ['page' => $tagihans->currentPage() + 1])) }}" class="btn btn-primary">Next</a>
        @else
            <span class="btn btn-primary disabled">Next</span>
        @endif
    </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Pembayaran Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('images/qris.jpg') }}" alt="QR Code" class="img-fluid mb-3">
                <p>Jumlah yang harus dibayar: <span id="jumlahPembayaran"></span></p>
                <a id="whatsappLink" href="#" class="btn btn-success">
                    <i class="bi bi-whatsapp"></i> Konfirmasi Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showPaymentModal(tagihanId, bulan, paketId) {
        console.log('showPaymentModal called', tagihanId, bulan, paketId);
        // Dapatkan harga paket dari server
        fetch(`{{ url('/get-paket-harga') }}/${paketId}`)
            .then(response => {
                console.log('fetch response', response);
                return response.json();
            })
            .then(data => {
                console.log('fetch data', data);
                const jumlahPembayaran = data.harga;
                document.getElementById('jumlahPembayaran').innerText = jumlahPembayaran;

                const whatsappLink = document.getElementById('whatsappLink');
                const namaPelanggan = '{{ Auth::user()->name }}';
                const whatsappMessage = `Hey Admin! \n\nAtas nama ${namaPelanggan}.\nBulan: ${bulan}\nSudah bayar: Rp${jumlahPembayaran} Tolong dicek dan diverifikasi ya! \n\nTerima ! `;
                whatsappLink.href = `https://wa.me/6285335243206?text=${encodeURIComponent(whatsappMessage)}`;

                $('#paymentModal').modal('show');
            });
    }
</script>
@endsection
