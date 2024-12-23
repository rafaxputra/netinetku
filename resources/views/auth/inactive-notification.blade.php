@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Akun Anda Dinonaktifkan</h4>
        <p>Akun Anda telah dinonaktifkan karena belum melakukan pembayaran tagihan. Silakan segera melakukan pembayaran.</p>
        <a href="{{ route('tagihan2.index') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-text"></i> Lihat Tagihan
        </a>
    </div>
</div>
@endsection
