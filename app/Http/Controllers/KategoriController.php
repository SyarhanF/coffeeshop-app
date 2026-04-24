<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('produks')
            ->latest()->paginate(10);
        return view('kategoris.index', compact('kategoris'));
    }

    // FIX: method create() yang hilang — ini penyebab error 500
    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(Kategori $kategori)
    {
        return redirect()->route('kategoris.index');
    }

    // FIX: method edit() juga perlu ada
    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}