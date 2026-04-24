@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-folder-fill me-2"></i>Manajemen Kategori</h2>
    <a href="{{ route('kategoris.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Kategori</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kat)
                <tr>
                    <td>{{ $kategoris->firstItem() + $i }}</td>
                    <td><strong>{{ $kat->nama_kategori }}</strong></td>
                    <td>{{ $kat->deskripsi ?? '-' }}</td>
                    <td><span class="badge bg-primary">{{ $kat->produks_count ?? 0 }} produk</span></td>
                    <td class="text-center">
                        <a href="{{ route('kategoris.edit', $kat->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form action="{{ route('kategoris.destroy', $kat->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus kategori {{ $kat->nama_kategori }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategoris->hasPages())
    <div class="card-footer">{{ $kategoris->links() }}</div>
    @endif
</div>
@endsection