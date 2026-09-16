<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    private array $daftarBuku = [
        1 => ["judul" => "Belajar PHP Dari Nol", "penulis" => "Saya"],
        2 => ["judul" => "Dasar Pemrograman Berorientasi Objek", "penulis" => "Saya juga"],
        3 => ["judul" => "Pengantar Basis Data", "penulis" => "Bukan Saya"],
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
