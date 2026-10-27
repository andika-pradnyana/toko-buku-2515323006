@extends('layouts.app')

@section('title', 'Daftar Penerbit - BookStore')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Penerbit</h1>
        <a href="{{ route('penerbit.create') }}" class="btn btn-primary">+ Tambah Penerbit</a>
    </div>

    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Penerbit</th>
            <th>Kota</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($daftarPenerbit as $penerbit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penerbit->name }}</td>
                <td>{{ $penerbit->city }}</td>
                <td>
                    <a href="{{ route('penerbit.edit', $penerbit->id) }}" class="btn btn-sm btn-outline-secondary">Ubah</a>
                    <form action="{{ route('penerbit.destroy', $penerbit->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin menghapus penerbit ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada penerbit.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection


