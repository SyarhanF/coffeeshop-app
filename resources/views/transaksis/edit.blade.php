@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('transaksis.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="page-title mb-0"><i class="bi bi-receipt me-2"></i>Edit Transaksi</h2>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0">Edit: <strong>{{ $transaksi->kode_transaksi }}</strong></h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kasir</label>
                    <select name="user_id" class="form-select" required>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ $transaksi->user_id == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Total Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="total_harga" class="form-control"
                               value="{{ $transaksi->total_harga }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Bayar</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="bayar" class="form-control"
                               value="{{ $transaksi->bayar }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kembalian</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="kembalian" class="form-control"
                               value="{{ $transaksi->kembalian }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="pending"  {{ $transaksi->status == 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="selesai"  {{ $transaksi->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="batal"    {{ $transaksi->status == 'batal'    ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="bi bi-save me-1"></i> Update Transaksi
                    </button>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection