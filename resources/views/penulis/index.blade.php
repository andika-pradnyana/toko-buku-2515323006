@extends('layouts.app')

@section('title', 'Daftar Penulis — BookStore')


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Penulis</h1>
        <a href="{{ route('penulis.create') }}" class="btn btn-primary">+ Tambah Penulis</a>
    </div>

    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Penulis</th>
            <th>Kota</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($daftarPenulis as $penulis)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penulis->name }}</td>
                <td>{{ $penulis->city }}</td>
                <td>
                    <a href="{{ route('penulis.edit', $penulis->id) }}" class="btn btn-sm btn-outline-secondary">Ubah</a>
                    <form action="{{ route('penulis.destroy', $penulis->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin menghapus penulis ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada penulis.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
