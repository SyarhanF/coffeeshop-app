<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller             
{
    /**
     * Display a listing of the resource.
     */
public function index() {
    $kategoris = Kategori::withCount('produks')
        ->latest()->paginate(10);
    return view('kategoris.index', compact('kategoris'));
}
public function store(Request $request) {
    $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategoris',
        'deskripsi'     => 'nullable|string',
    ]);
    Kategori::create($request->all());
    return redirect()->route('kategoris.index')
        ->with('success', 'Kategori berhasil ditambahkan!');
}
public function update(Request $request, Kategori $kategori) {
    $request->validate([
        'nama_kategori' => 'required|string|max:100',
    ]);
    $kategori->update($request->all());
    return redirect()->route('kategoris.index')
        ->with('success', 'Kategori berhasil diupdate!');
}
public function destroy(Kategori $kategori) {
    $kategori->delete();
    return redirect()->route('kategoris.index')
        ->with('success', 'Kategori berhasil dihapus!');
}}