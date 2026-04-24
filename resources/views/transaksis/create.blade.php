@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-9">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('transaksis.index') }}" class="btn btn-outline-secondary btn-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="page-title mb-0"><i class="bi bi-receipt me-2"></i>Tambah Transaksi</h2>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0">Form Transaksi Baru</h5>
        </div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('transaksis.store') }}" method="POST" id="formTrx">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kasir <span class="text-danger">*</span></label>
                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kasir --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Produk <span class="text-danger">*</span></label>
                    <div id="produk-list">
                        <div class="row g-2 mb-2 produk-item">
                            <div class="col-md-6">
                                <select name="produk_ids[]" class="form-select produk-select" onchange="hitungTotal()">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produks as $p)
                                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="qtys[]" class="form-control qty-input"
                                       placeholder="Qty" min="1" value="1" onchange="hitungTotal()">
                            </div>
                            <div class="col-md-3">
                                <span class="form-control bg-light subtotal-item">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="tambahProduk()">
                        <i class="bi bi-plus"></i> Tambah Produk
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Total Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_harga" id="total_harga" class="form-control bg-light"
                                   readonly placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="bayar" id="bayar" class="form-control @error('bayar') is-invalid @enderror"
                                   placeholder="0" min="0" onkeyup="hitungKembalian()" required>
                            @error('bayar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="kembalian" id="kembalian" class="form-control bg-light" readonly placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
const produkOptions = `@foreach($produks as $p)<option value="{{ $p->id }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }} - Rp {{ number_format($p->harga,0,',','.') }}</option>@endforeach`;

function tambahProduk() {
    const div = document.createElement('div');
    div.className = 'row g-2 mb-2 produk-item';
    div.innerHTML = `
        <div class="col-md-6">
            <select name="produk_ids[]" class="form-select produk-select" onchange="hitungTotal()">
                <option value="">-- Pilih Produk --</option>${produkOptions}
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="qtys[]" class="form-control qty-input" placeholder="Qty" min="1" value="1" onchange="hitungTotal()">
        </div>
        <div class="col-md-2">
            <span class="form-control bg-light subtotal-item">Rp 0</span>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm w-100" onclick="this.closest('.produk-item').remove(); hitungTotal()">
                <i class="bi bi-trash"></i>
            </button>
        </div>`;
    document.getElementById('produk-list').appendChild(div);
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.produk-item').forEach(item => {
        const sel = item.querySelector('.produk-select');
        const qty = parseInt(item.querySelector('.qty-input').value) || 0;
        const harga = sel.selectedOptions[0]?.dataset.harga || 0;
        const sub = parseInt(harga) * qty;
        item.querySelector('.subtotal-item').textContent = 'Rp ' + sub.toLocaleString('id-ID');
        total += sub;
    });
    document.getElementById('total_harga').value = total;
    hitungKembalian();
}

function hitungKembalian() {
    const total = parseInt(document.getElementById('total_harga').value) || 0;
    const bayar = parseInt(document.getElementById('bayar').value) || 0;
    document.getElementById('kembalian').value = bayar - total;
}
</script>
@endsection