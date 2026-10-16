@extends('layouts.app')

@section('title', 'Daftar Kategori - BookStore')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Kategori</h1>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Kategori</th>
            <th style="width: 120px;">Jumlah Buku</th>
            <th style="width: 180px;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($daftarKategori as $kategori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori->name }}</td>
                <td>{{ $kategori->books_count }}</td>
                <td>
                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-outline-secondary">Ubah</a>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada kategori.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection


