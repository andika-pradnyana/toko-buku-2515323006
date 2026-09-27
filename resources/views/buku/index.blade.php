{{-- resources/views/buku/index.blade.php (contoh lengkap) --}}
@extends('layouts.app')

@section('title', 'Daftar Buku — BookStore')

@section('content')
    <h1 class="mb-4">Daftar Buku</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($daftarBuku as $id => $buku)
            <div class="col">
                <div class="card h-100 kartu-buku">
                    <img src="{{ asset('images/sampul-placeholder.png') }}" class="card-img-top" alt="Sampul {{ $buku['judul'] }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $buku['judul'] }}</h5>
                        <p class="card-text text-muted mb-1">{{ $buku['penulis'] }}</p>
                        <p class="card-text harga-buku">Rp{{ number_format($buku['harga'], 0, ',', '.') }}</p>
                        <a href="{{ url('/buku/'.$id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
