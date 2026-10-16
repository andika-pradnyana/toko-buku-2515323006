<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return view('buku.index', ['daftarBuku' => Book::with('category')->get()]);
    }

    public function show($id)
    {
       $buku = Book::with('category')->find($id);

       return view('buku.show', ['buku' => $buku, 'id' => $id]);
    }
}
