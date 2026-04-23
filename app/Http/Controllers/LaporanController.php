<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
   
    public function index() {
        $laporans = Laporan::latest()->paginate(10);
        return view('laporans.index', compact('laporans'));
    }
    public function create() {
        return view('laporans.create');
    }
    public function store(Request $request) {
        $request->validate([
            'judul'           => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);
        $total = Transaksi::whereBetween('created_at', [
            $request->tanggal_mulai,
            $request->tanggal_selesai
        ])->where('status','selesai');
        Laporan::create([
            'judul'            => $request->judul,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'total_transaksi'  => $total->count(),
            'total_pendapatan' => $total->sum('total_harga'),
            'keterangan'       => $request->keterangan,
        ]);
    return redirect()->route('laporans.index')
        ->with('success', 'Laporan berhasil dibuat!');
    }
    public function destroy(Laporan $laporan) {
        $laporan->delete();
        return redirect()->route('laporans.index')
            ->with('success', 'Laporan dihapus!');
    }
}
