@extends('layouts.app')

@section('title', 'Ubah Penerbit — BookStore')

@section('content')
    <h1 class="mb-4">Ubah Penerbit</h1>

    <form action="{{ route('penerbit.update', $penerbit->id) }}" method="POST" style="max-width: 480px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Penerbit</label>
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $penerbit->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="name" class="form-label">Kota Penerbit</label>
            <input type="text" id="city" name="city"
                   class="form-control @error('city') is-invalid @enderror"
                   value="{{ old('city', $penerbit->city) }}">
            @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('penerbit.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
@endsection
