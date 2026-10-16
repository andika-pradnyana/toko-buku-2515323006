@extends('layouts.app')

@section('title', 'Ubah Kategori — BookStore')

@section('content')
    <h1 class="mb-4">Ubah Kategori</h1>

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" style="max-width: 480px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $kategori->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
@endsection
