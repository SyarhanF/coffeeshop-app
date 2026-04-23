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
            'nama_produk'  => 'required|string|max:100',
            'kategori_id'  => 'required|exists:kategoris,id',
            'harga'        => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
        ]);

        $data = $request->except('gambar');
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('produks', 'public');
        }

        Produk::create($data);
        return redirect()->route('produks.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        //
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('produks.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->except(['gambar', '_token', '_method']);
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('produks', 'public');
        }

        $produk->update($data);
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