@extends('layouts.app')

@section('title', 'Tambah Buku — BookStore')

@section('content')
    <h1 class="mb-4">Tambah Buku</h1>

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 560px;">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" id="title" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="author_name" class="form-label">Penulis</label>
            <input type="text" id="author_name" name="author_name"
                   class="form-control @error('author_name') is-invalid @enderror"
                   value="{{ old('author_name') }}">
            @error('author_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select id="category_id" name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Pilih kategori --</option>
                @foreach ($daftarKategori as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('category_id') == $kategori->id)>
                        {{ $kategori->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="publisher_id" class="form-label">Penerbit</label>
            <select id="publisher_id" name="publisher_id"
                    class="form-select @error('publisher_id') is-invalid @enderror">
                <option value="">-- Pilih penerbit --</option>
                @foreach ($daftarPenerbit as $penerbit)
                    <option value="{{ $penerbit->id }}" @selected(old('publisher_id') == $penerbit->id)>
                        {{ $penerbit->name }} ({{ $penerbit->city }})
                    </option>
                @endforeach
            </select>
            @error('publisher_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="text" id="price" name="price"
                   class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price') }}">
            @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Sampul (opsional, JPG/PNG, maksimal 2 MB)</label>
            <input type="file" id="cover" name="cover"
                   class="form-control @error('cover') is-invalid @enderror">
            @error('cover')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
@endsection
