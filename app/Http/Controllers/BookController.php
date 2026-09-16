<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    private array $daftarBuku = [
        1 => ['judul' => 'Clean Code', 'penulis' => 'Robert C. Martin'],
        2 => ['judul' => 'Atomic Habits', 'penulis' => 'James Clear'],
        3 => ['judul' => 'Clean Architecture', 'penulis' => 'Robert C. Martin'],
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
