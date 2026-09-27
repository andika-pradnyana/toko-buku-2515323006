<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    private array $daftarBuku = [
        1 => ['judul' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'harga' => 85000],
        2 => ['judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'harga' => 75000],
        3 => ['judul' => 'Clean Architecture', 'penulis' => 'Robert C. Martin', 'harga' => 100000],
    ];

    public function index()
    {
        return view('buku.index', ['daftarBuku' => $this->daftarBuku]);
    }

    public function show($id)
    {
       $buku = $this->daftarBuku[$id] ?? null;
       return view('buku.show', ['buku' => $buku, 'id' => $id]);
    }
}
