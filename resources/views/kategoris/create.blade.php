@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('kategoris.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="page-title mb-0"><i class="bi bi-folder-plus me-2"></i>Tambah Kategori</h2>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0">Form Tambah Kategori Baru</h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('kategoris.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori"
                           class="form-control @error('nama_kategori') is-invalid @enderror"
                           value="{{ old('nama_kategori') }}"
                           placeholder="Contoh: Minuman Panas, Makanan Ringan" required>
                    @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Kategori
                    </button>
                    <a href="{{ route('kategoris.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection