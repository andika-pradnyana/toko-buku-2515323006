{{-- resources/views/buku/index.blade.php (contoh lengkap) --}}
@extends('layouts.app')

@section('title', 'Daftar Buku — BookStore')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Buku</h1>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($daftarBuku as $buku)
            <div class="col">
                <div class="card h-100 kartu-buku">
                    <img src="{{ $buku->cover_url }}" class="card-img-top" alt="Sampul {{ $buku->title }}">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary align-self-start mb-2">{{ $buku->category->name }}</span>
                        <h5 class="card-title">{{ $buku->title }}</h5>
                        <p class="card-text text-muted mb-1">{{ $buku->author_name }}</p>
                        <p class="card-text small text-muted mb-1">{{ $buku->publisher?->name ?? 'Penerbit belum diisi' }}</p>
                        <p class="card-text harga-buku">Rp{{ number_format($buku->price, 0, ',', '.') }}</p>
                        <a href="{{ url('/buku/'.$buku->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
