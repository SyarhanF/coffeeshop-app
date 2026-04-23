<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index() {
        $transaksis = Transaksi::with('user')
            ->latest()->paginate(10);
        return view('transaksis.index', compact('transaksis'));
    }

    public function create() {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('transaksis.create', compact('produks'));
    }

    public function store(Request $request) {
        $request->validate([
            'produk_ids' => 'required|array',
            'qtys'       => 'required|array',
            'bayar'      => 'required|integer',
        ]);

        $total = 0;
        foreach($request->produk_ids as $i => $pid) {
            $p = Produk::find($pid);
            $total += $p->harga * $request->qtys[$i];
        }

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX-'.date('Ymd').'-'.rand(1000,9999),
            'user_id'        => auth()->id() ?? 1,
            'total_harga'    => $total,
            'bayar'          => $request->bayar,
            'kembalian'      => $request->bayar - $total,
            'status'         => 'selesai',
        ]);

        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function destroy(Transaksi $transaksi) {
        $transaksi->update(['status' => 'batal']);
        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi dibatalkan!');
    }
}
