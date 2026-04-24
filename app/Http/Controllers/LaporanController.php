<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Transaksi; // FIX: ini yang menyebabkan error "Class Transaksi not found"
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);
        return view('laporans.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:200',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'nullable|string',
        ]);

        // Hitung otomatis dari tabel transaksis berdasarkan periode
        $query = Transaksi::whereBetween('created_at', [
            $request->tanggal_mulai . ' 00:00:00',
            $request->tanggal_selesai . ' 23:59:59',
        ])->where('status', 'selesai');

        Laporan::create([
            'judul'            => $request->judul,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'total_transaksi'  => $query->count(),
            'total_pendapatan' => $query->sum('total_harga'),
            'keterangan'       => $request->keterangan,
        ]);

        return redirect()->route('laporans.index')
            ->with('success', 'Laporan berhasil dibuat!');
    }

    public function show(Laporan $laporan)
    {
        return redirect()->route('laporans.index');
    }

    public function edit(Laporan $laporan)
    {
        return view('laporans.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'judul'            => 'required|string|max:200',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'total_transaksi'  => 'nullable|integer|min:0',
            'total_pendapatan' => 'nullable|integer|min:0',
            'keterangan'       => 'nullable|string',
        ]);

        $laporan->update($request->all());

        return redirect()->route('laporans.index')
            ->with('success', 'Laporan berhasil diupdate!');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporans.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}