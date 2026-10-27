<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return view('buku.index', ['daftarBuku' => Book::with('category', 'publisher')->latest('id')->get()]);
    }

    public function show($id)
    {
       $buku = Book::with('category', 'publisher')->find($id);

       return view('buku.show', ['buku' => $buku, 'id' => $id]);
    }

    public function create()
    {
       return view('buku.create', ['daftarKategori' => Category::orderBy('name')->get(), 'daftarPenerbit' => Publisher::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->aturan(), $this->pesan());

        // Isi cover di $validated adalah objek berkas upload (atau null), bukan
        // nama berkas untuk database -- buang dulu, lalu isi dengan hasil store().
        unset($validated['cover']);
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('sampul', 'public');
        }

        Book::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    private function aturan(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'price' => 'required|numeric|min:0|max:99999999',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'published_year' => 'nullable|integer|min:1900|max:2100'
        ];
    }

    private function pesan(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi.',
            'title.max' => 'Judul buku maksimal 255 karakter.',
            'author_name.required' => 'Nama penulis wajib diisi.',
            'author_name.max' => 'Nama penulis maksimal 255 karakter.',
            'category_id.required' => 'Pilih salah satu kategori.',
            'category_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'publisher_id.required' => 'Pilih salah satu penerbit.',
            'publisher_id.exists' => 'Penerbit yang dipilih tidak ditemukan.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'price.max' => 'Harga terlalu besar (maksimal 99.999.999).',
            'cover.image' => 'Sampul harus berupa gambar.',
            'cover.mimes' => 'Sampul harus berformat JPG atau PNG.',
            'cover.max' => 'Ukuran sampul maksimal 2 MB.',
            'cover.uploaded' => 'Sampul gagal diunggah. Periksa ukuran berkas (maksimal 2 MB).',
            'published_year.integer' => 'Tahun terbit harus berupa angka.',
            'published_year.min' => 'Tahun terbit minimal tahun 1900.',
            'published_year.max' => 'Tahun terbit maksimal tahun 2100.',
        ];
    }

    public function edit(string $id)
    {
        return view('buku.edit', [
            'buku' => Book::findOrFail($id),
            'daftarKategori' => Category::orderBy('name')->get(),
            'daftarPenerbit' => Publisher::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $buku = Book::findOrFail($id);

        $validated = $request->validate($this->aturan(), $this->pesan());

        unset($validated['cover']);
        $coverLama = null;
        if ($request->hasFile('cover')) {
            $coverLama = $buku->cover;
            $validated['cover'] = $request->file('cover')->store('sampul', 'public');
        }

        $buku->update($validated);

        if ($coverLama) {
            Storage::disk('public')->delete($coverLama);
        }

        return redirect()->route('buku.show', $buku->id)
            ->with('success', 'Buku berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $buku = Book::findOrFail($id);

        $buku->delete();

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }



}
