<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $kataKunci = $request->query('q');
        $kategoriId = $request->query('kategori');
        $penerbitId = $request->query('penerbit');

        $daftarBuku = Book::with(['category', 'publisher'])
            ->when($kataKunci, function ($query, $kataKunci) {
                $query->where(function ($query) use ($kataKunci) {
                    $query->where('title', 'like', '%' . $kataKunci . '%')
                        ->orWhere('author_name', 'like', '%' . $kataKunci . '%');
                });
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                $query->where('category_id', $kategoriId);
            })
            ->when($penerbitId, function ($query, $penerbitId) {
                $query->where('publisher_id', $penerbitId);
            })
            ->latest('id')
            ->paginate(3)
            ->withQueryString();

        return view('buku.index', [
            'daftarBuku' => $daftarBuku,
            'daftarKategori' => Category::orderBy('name')->get(),
            'daftarPenerbit' => Publisher::orderBy('name')->get(),
            'kataKunci' => $kataKunci,
            'kategoriId' => $kategoriId,
            'penerbitId' => $penerbitId,
        ]);

    }

    public function show($id)
    {
        $buku = Book::with(['category', 'publisher'])->find($id);

        $bukuSerupa = $buku
            ? $buku->category->books()->whereKeyNot($buku->id)->latest('id')->limit(3)->get()
            : collect();

        return view('buku.show', [
            'buku' => $buku,
            'id' => $id,
            'bukuSerupa' => $bukuSerupa,
        ]);
    }

    public function create()
    {
       return view('buku.create', ['daftarKategori' => Category::orderBy('name')->get(), 'daftarPenerbit' => Publisher::orderBy('name')->get(), 'daftarPenulis' => Author::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->aturan(), $this->pesan());

        if (!empty($validated['author_name'])) {
            // Jika mengetik nama penulis baru -> buat/cari di tabel authors
            $penulis = Author::firstOrCreate([
                'name' => trim($validated['author_name']),
            ]);
            $validated['author_id']   = $penulis->id;
            $validated['author_name'] = $penulis->name;
        } else {
            // Jika memilih dari dropdown -> ambil namanya dari tabel authors
            $penulis = Author::findOrFail($validated['author_id']);
            $validated['author_name'] = $penulis->name;
        }

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
            /*'author_name' => Rule::exists("authors", "name"),*/
            'author_name'    => 'nullable|required_without:author_id|string|max:255',
            'category_id' => 'required|exists:categories,id',
            /*'author_id' => 'required|exists:authors,id',*/
            'author_id'      => 'nullable|required_without:author_name|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'price' => 'required|integer|min:0|max:99999999',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|integer|min:0|max:100000',
            'published_year' => 'nullable|integer|min:1900|max:2100'

        ];
    }

    private function pesan(): array
    {
        return [
            'author_id.required_without'   => 'Pilih penulis dari daftar atau ketik nama penulis baru.',
            'author_name.required_without' => 'Nama penulis wajib diisi jika tidak memilih dari daftar.',
            'author_id.exists'             => 'Penulis yang dipilih tidak valid.',
            'title.required' => 'Judul buku wajib diisi.',
            'title.max' => 'Judul buku maksimal 255 karakter.',
            'author_name.required' => 'Nama penulis wajib diisi.',
            'author_name.max' => 'Nama penulis maksimal 255 karakter.',
            'author_name.exists' => 'Nama penulis tidak ditemukan.',
            'category_id.required' => 'Pilih salah satu kategori.',
            'category_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'publisher_id.required' => 'Pilih salah satu penerbit.',
            'publisher_id.exists' => 'Penerbit yang dipilih tidak ditemukan.',
            'price.integer' => 'Harga harus berupa bilangan bulat tanpa titik atau koma (contoh: 85000).',
            'price.required' => 'Harga wajib diisi.',
            'price.min' => 'Harga tidak boleh negatif.',
            'price.max' => 'Harga terlalu besar (maksimal 99.999.999).',
            'stock.required' => 'Stok wajib diisi (isi 0 bila habis).',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'stock.max' => 'Stok terlalu besar (maksimal 100.000).',
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
            'daftarPenulis' => Author::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $buku = Book::findOrFail($id);

        $validated = $request->validate($this->aturan(), $this->pesan());

        if (!empty($validated['author_name'])) {
            // Jika mengetik nama penulis baru -> buat/cari di tabel authors
            $penulis = Author::firstOrCreate([
                'name' => trim($validated['author_name']),
            ]);
            $validated['author_id']   = $penulis->id;
            $validated['author_name'] = $penulis->name;
        } else {
            // Jika memilih dari dropdown -> ambil namanya dari tabel authors
            $penulis = Author::findOrFail($validated['author_id']);
            $validated['author_name'] = $penulis->name;
        }

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
