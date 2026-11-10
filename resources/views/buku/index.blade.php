@extends('layouts.app')

@section('title', 'Daftar Buku — BookStore')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Buku</h1>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    <form action="{{ route('buku.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="q" class="form-control"
                   placeholder="Cari judul atau penulis" value="{{ $kataKunci }}">
        </div>
        <div class="col-md-4">
            <select name="kategori" class="form-select">
                <option value="">Semua kategori</option>
                @foreach ($daftarKategori as $kategori)
                    <option value="{{ $kategori->id }}" @selected($kategoriId == $kategori->id)>
                        {{ $kategori->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="penerbit" class="form-select">
                <option value="">Semua penerbit</option>
                @foreach ($daftarPenerbit as $penerbit)
                    <option value="{{ $penerbit->id }}" @selected($penerbitId == $penerbit->id)>
                        {{ $penerbit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Cari</button>
            @if ($kataKunci || $kategoriId)
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    @if ($daftarBuku->isEmpty())
        <div class="alert alert-info">Tidak ada buku yang cocok.</div>
    @else
        <p class="text-muted small">
            Menampilkan buku {{ $daftarBuku->firstItem() }} sampai {{ $daftarBuku->lastItem() }}
            dari {{ $daftarBuku->total() }} buku.
        </p>

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
                            <p class="card-text harga-buku mb-1">Rp{{ number_format($buku->price, 0, ',', '.') }}</p>
                            @if ($buku->stock > 0)
                                <p class="card-text small mb-2">Stok: {{ $buku->stock }}</p>
                            @else
                                <p class="card-text mb-2"><span class="badge bg-danger">Stok habis</span></p>
                            @endif
                            <a href="{{ url('/buku/'.$buku->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $daftarBuku->links() }}
        </div>
    @endif
@endsection
