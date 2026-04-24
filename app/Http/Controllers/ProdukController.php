<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->paginate(10);
        return view('produks.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produks.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
        ]);

        Produk::create($request->all());

        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        return redirect()->route('produks.index');
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('produks.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
        ]);

        $produk->update($request->all());

        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}