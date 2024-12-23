@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card glass-effect">
        <div class="card-header">
            <i class="bi bi-file-earmark-plus-fill"></i> Tambah Tagihan
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
            <form method="POST" action="{{ route('tagihan.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="pelanggan_id" class="form-label">Pelanggan</label>
                    <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    @error('tanggal')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    @error('jumlah')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum lunas">Belum Lunas</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Tambah
                </button>
                <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pelangganSelect = document.getElementById('pelanggan_id');
        const jumlahInput = document.getElementById('jumlah');

        pelangganSelect.addEventListener('change', function () {
            const pelangganId = this.value;
            if (pelangganId) {
                fetch(`/get-pelanggan-paket/${pelangganId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.paket_id) {
                            fetch(`/get-paket-harga/${data.paket_id}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data && data.harga) {
                                        jumlahInput.value = data.harga;
                                        jumlahInput.dataset.basePrice = data.harga;
                                    } else {
                                        jumlahInput.value = '';
                                        jumlahInput.dataset.basePrice = 0;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching package price:', error);
                                    jumlahInput.value = '';
                                    jumlahInput.dataset.basePrice = 0;
                                });
                        } else {
                            jumlahInput.value = '';
                            jumlahInput.dataset.basePrice = 0;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching customer data:', error);
                        jumlahInput.value = '';
                        jumlahInput.dataset.basePrice = 0;
                    });
            } else {
                jumlahInput.value = '';
                jumlahInput.dataset.basePrice = 0;
            }
        });

        jumlahInput.addEventListener('input', function() {
            const basePrice = parseFloat(this.dataset.basePrice) || 0;
            const inputValue = parseFloat(this.value) || 0;
            this.value = basePrice + inputValue;
        });
    });
</script>
@endsection
