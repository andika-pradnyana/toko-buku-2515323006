<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penerbit.index', ['daftarPenerbit' => Publisher::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerbit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => preg_replace('/\s+/', ' ', trim($request->name)),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique(Publisher::class, 'name')],
            'city' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama Penerbit wajib diisi.',
            'name.max' => 'Nama Penerbit maksimal 100 karakter.',
            'name.unique' => 'Nama Penerbit ini sudah dipakai.',
            'city.required' => 'Nama Kota wajib diisi.',
            'city.max' => 'Nama Kota maksimal 100 karakter.',
        ]);

        Publisher::create($validated);

        return redirect()->route('penerbit.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
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
        return view('penerbit.edit', [
            'penerbit' => Publisher::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penerbit = Publisher::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('publishers', 'name')->ignore($penerbit->id),
            ],
            'city' => [
                'required',
                'string',
                'max:100',
                Rule::unique('publishers', 'city')->ignore($penerbit->id),
            ],
        ], [
            'name.required' => 'Nama penerbit wajib diisi.',
            'name.max' => 'Nama penerbit maksimal 100 karakter.',
            'name.unique' => 'Nama penerbit ini sudah dipakai.',
            'city.required' => 'Nama Kota wajib diisi.',
            'city.max' => 'Nama Kota maksimal 100 karakter.',
        ]);

        $penerbit->update($validated);

        return redirect()->route('penerbit.index')
            ->with('success', 'Penerbit berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penerbit = Publisher::findOrFail($id);

        try {
            $penerbit->delete();
        } catch (QueryException $e) {
            if ($e->getCode() !== '23000') {
                throw $e;
            }

            return redirect()->route('penerbit.index')
                ->with('error', 'Penerbit "' . $penerbit->name . '" tidak bisa dihapus karena masih dipakai oleh buku.');
        }

        return redirect()->route('penerbit.index')
            ->with('success', 'Penerbit berhasil dihapus.');

    }
}
