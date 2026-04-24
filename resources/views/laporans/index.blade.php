@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-bar-chart-fill me-2"></i>Manajemen Laporan</h2>
    <a href="{{ route('laporans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Buat Laporan
    </a>
</div>

<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Laporan</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Laporan</th>
                    <th>Periode</th>
                    <th>Total Transaksi</th>
                    <th>Total Pendapatan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $i => $lap)
                <tr>
                    <td>{{ $laporans->firstItem() + $i }}</td>
                    <td><strong>{{ $lap->judul }}</strong></td>
                    <td>
                        <small>{{ \Carbon\Carbon::parse($lap->tanggal_mulai)->format('d/m/Y') }}
                        — {{ \Carbon\Carbon::parse($lap->tanggal_selesai)->format('d/m/Y') }}</small>
                    </td>
                    <td><span class="badge bg-primary">{{ $lap->total_transaksi }} transaksi</span></td>
                    <td><strong class="text-success">Rp {{ number_format($lap->total_pendapatan, 0, ',', '.') }}</strong></td>
                    <td>{{ $lap->keterangan ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('laporans.edit', $lap->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('laporans.destroy', $lap->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus laporan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada laporan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($laporans->hasPages())
    <div class="card-footer">{{ $laporans->links() }}</div>
    @endif
</div>
@endsection