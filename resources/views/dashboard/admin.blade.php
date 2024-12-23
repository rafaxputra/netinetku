@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Card Jumlah Pelanggan -->
        <div class="col-md-4 mb-4">
            <div class="card glass-effect">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">Jumlah Pelanggan</h5>
                    <p class="card-text">{{ $jumlahPelanggan }}</p>
                </div>
            </div>
        </div>
        <!-- Card Pendapatan Bulanan -->
        <div class="col-md-4 mb-4">
            <div class="card glass-effect">
                <div class="card-body text-center">
                    <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">Pendapatan Bulanan</h5>
                    <p class="card-text">Rp{{ number_format($pendapatanBulanIni->pendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <!-- Card Tanggal Hari Ini -->
        <div class="col-md-4 mb-4">
            <div class="card glass-effect">
                <div class="card-body text-center">
                    <i class="bi bi-calendar" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">Tanggal Hari Ini</h5>
                    <p class="card-text">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
                    <canvas id="pendapatanChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
        var pendapatanData = @json($pendapatanBulanan);
       var pendapatanLabels = pendapatanData.map(function(item) {
            return item.bulan;
        });
        var pendapatanValues = pendapatanData.map(function(item) { return item.pendapatan; });

        new Chart(ctxPendapatan, {
            type: 'line',
            data: {
                labels: pendapatanLabels,
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: pendapatanValues,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
