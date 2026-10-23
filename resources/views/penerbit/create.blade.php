@extends('layouts.app')

@section('title', 'Tambah Penerbit — BookStore')

@section('content')
    <h1 class="mb-4">Tambah Penerbit</h1>

    <form action="{{ route('penerbit.store') }}" method="POST" style="max-width: 480px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Penerbit</label>
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="city" class="form-label">Kota Penerbit</label>
            <input type="text" id="city" name="city"
                   class="form-control @error('city') is-invalid @enderror"
                   value="{{ old('city') }}">
            @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penerbit.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
@endsection

