@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('laporans.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="page-title mb-0"><i class="bi bi-bar-chart me-2"></i>Buat Laporan</h2>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0">Form Laporan Baru</h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Total transaksi & pendapatan akan dihitung otomatis berdasarkan periode yang dipilih.
            </div>

            <form action="{{ route('laporans.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Laporan <span class="text-danger">*</span></label>
                    <input type="text" name="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}"
                           placeholder="Contoh: Laporan Bulan April 2026" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai"
                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_selesai"
                               class="form-control @error('tanggal_selesai') is-invalid @enderror"
                               value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Generate Laporan
                    </button>
                    <a href="{{ route('laporans.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection