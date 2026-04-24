@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('produks.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="page-title mb-0"><i class="bi bi-cup-hot me-2"></i>Edit Produk</h2>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0">Edit: <strong>{{ $produk->nama_produk }}</strong></h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk"
                               class="form-control @error('nama_produk') is-invalid @enderror"
                               value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ old('kategori_id', $produk->kategori_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', $produk->harga) }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok"
                               class="form-control @error('stok') is-invalid @enderror"
                               value="{{ old('stok', $produk->stok) }}" min="0" required>
                        @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Deskripsi produk (opsional)">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="bi bi-save me-1"></i> Update Produk
                    </button>
                    <a href="{{ route('produks.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection