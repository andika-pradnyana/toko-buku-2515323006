<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penulis.index', ['daftarPenulis' => Author::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('penulis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique(Author::class, 'name')],
            'city' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama Penulis wajib diisi.',
            'name.max' => 'Nama Penulis maksimal 100 karakter.',
            'name.unique' => 'Nama Penulis ini sudah dipakai.',
            'city.required' => 'Nama Kota wajib diisi.',
            'city.max' => 'Nama Kota maksimal 100 karakter.',
        ]);

        Author::create($validated);

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('penulis.edit', [
            'penulis' => Author::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penulis = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('authors', 'name')->ignore($penulis->id),
            ],
            'city' => [
                'required',
                'string',
                'max:100',
                Rule::unique('authors', 'city')->ignore($penulis->id),
            ],
        ], [
            'name.required' => 'Nama penerbit wajib diisi.',
            'name.max' => 'Nama penerbit maksimal 100 karakter.',
            'name.unique' => 'Nama penerbit ini sudah dipakai.',
            'city.required' => 'Nama Kota wajib diisi.',
            'city.max' => 'Nama Kota maksimal 100 karakter.',
        ]);

        $penulis->update($validated);

        return redirect()->route('penulis.index')
            ->with('success', 'Penerbit berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penulis = Author::findOrFail($id);

        try {
            $penulis->delete();
        } catch (QueryException $e) {
            if ($e->getCode() !== '23000') {
                throw $e;
            }

            return redirect()->route('penulis.index')
                ->with('error', 'Penulis"' . $penulis->name . '" tidak bisa dihapus karena masih dipakai oleh buku.');
        }

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil dihapus.');
    }
}
