<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->paginate(10);
        return view('transaksis.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        $users   = User::all();
        return view('transaksis.create', compact('produks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_harga' => 'required|integer|min:0',
            'bayar'       => 'required|integer|min:0',
            'kembalian'   => 'required|integer',
        ]);

        Transaksi::create([
            'kode_transaksi' => 'TRX-' . date('Ymd') . '-' . rand(1000, 9999),
            'user_id'        => $request->user_id,
            'total_harga'    => $request->total_harga,
            'bayar'          => $request->bayar,
            'kembalian'      => $request->kembalian,
            'status'         => 'selesai',
        ]);

        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show(Transaksi $transaksi)
    {
        return redirect()->route('transaksis.index');
    }

    public function edit(Transaksi $transaksi)
    {
        $users = User::all();
        return view('transaksis.edit', compact('transaksi', 'users'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'total_harga'      => 'required|integer|min:0',
            'bayar'            => 'required|integer|min:0',
            'kembalian'        => 'required|integer',
            'status'           => 'required|in:pending,selesai,batal',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'batal']);
        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil dibatalkan!');
    }
}