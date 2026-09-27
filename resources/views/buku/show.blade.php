{{-- resources/views/buku/show.blade.php (contoh lengkap) --}}
@extends('layouts.app')

@section('title', ($buku['judul'] ?? 'Buku tidak ditemukan') . ' — BookStore')

@section('content')
    @if ($buku)
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('images/sampul-placeholder.png') }}" class="img-fluid rounded"
                     alt="Sampul {{ $buku['judul'] }}">
            </div>
            <div class="col-md-8">
                <h1>{{ $buku['judul'] }}</h1>
                <p class="text-muted">Penulis: {{ $buku['penulis'] }}</p>
                <p class="harga-buku fs-4">Rp{{ number_format($buku['harga'], 0, ',', '.') }}</p>
                <a href="{{ url('/buku') }}" class="btn btn-outline-secondary">&larr; Kembali ke daftar buku</a>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <h1 class="h4">Buku tidak ditemukan</h1>
            <p class="mb-0">Tidak ada buku dengan id {{ $id }}.</p>
        </div>
        <a href="{{ url('/buku') }}" class="btn btn-outline-secondary mt-3">&larr; Kembali ke daftar buku</a>
    @endif
@endsection
