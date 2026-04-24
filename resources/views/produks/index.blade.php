@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-cup-hot-fill me-2"></i>Manajemen Produk</h2>
    <a href="{{ route('produks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Produk</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $i => $produk)
                <tr>
                    <td>{{ $produks->firstItem() + $i }}</td>
                    <td><strong>{{ $produk->nama_produk }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $produk->kategori->nama_kategori ?? '-' }}</span></td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($produk->stok <= 5)
                            <span class="badge bg-danger">{{ $produk->stok }} (Habis)</span>
                        @else
                            <span class="badge bg-success">{{ $produk->stok }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('produks.edit', $produk->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus produk {{ $produk->nama_produk }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada produk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($produks->hasPages())
    <div class="card-footer">{{ $produks->links() }}</div>
    @endif
</div>
@endsection