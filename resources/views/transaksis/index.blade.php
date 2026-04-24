@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-receipt me-2"></i>Manajemen Transaksi</h2>
    <a href="{{ route('transaksis.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
    </a>
</div>

<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Transaksi</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $i => $trx)
                <tr>
                    <td>{{ $transaksis->firstItem() + $i }}</td>
                    <td><code>{{ $trx->kode_transaksi }}</code></td>
                    <td>{{ $trx->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                    <td>
                        @if($trx->status === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($trx->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-danger">Batal</span>
                        @endif
                    </td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <a href="{{ route('transaksis.edit', $trx->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('transaksis.destroy', $trx->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin batalkan transaksi ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Batal
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transaksis->hasPages())
    <div class="card-footer">{{ $transaksis->links() }}</div>
    @endif
</div>
@endsection