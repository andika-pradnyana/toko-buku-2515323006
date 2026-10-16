@extends('layouts.app')

@section('title', 'Tambah Kategori — BookStore')

@section('content')
    <h1 class="mb-4">Tambah Kategori</h1>

    <form action="{{ route('kategori.store') }}" method="POST" style="max-width: 480px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
@endsection
