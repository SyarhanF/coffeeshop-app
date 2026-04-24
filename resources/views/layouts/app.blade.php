<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>☕ Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f5f0; }
        .navbar { background: linear-gradient(135deg, #2c1810, #4a2c2a) !important; }
        .navbar-brand { font-weight: 700; font-size: 1.3rem; color: #f5c842 !important; }
        .nav-link-btn {
            color: #fff !important;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 6px;
            padding: 5px 14px;
            font-size: 13px;
            text-decoration: none;
            transition: all .2s;
        }
        .nav-link-btn:hover, .nav-link-btn.active {
            background: #f5c842;
            color: #2c1810 !important;
            border-color: #f5c842;
            font-weight: 600;
        }
        .card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.08); border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; background: linear-gradient(135deg, #2c1810, #4a2c2a); color: #fff; }
        .btn-primary { background: #2c1810; border-color: #2c1810; }
        .btn-primary:hover { background: #4a2c2a; border-color: #4a2c2a; }
        .btn-warning { background: #f5c842; border-color: #f5c842; color: #2c1810; font-weight: 600; }
        .table thead th { background: #f5c842; color: #2c1810; font-weight: 700; border: none; }
        .badge-role { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .page-title { font-weight: 700; color: #2c1810; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark px-4 py-3">
    <a class="navbar-brand" href="/">☕ Coffee Shop</a>
    <div class="d-flex gap-2 flex-wrap">
        <a href="/users"     class="nav-link-btn {{ request()->is('users*')     ? 'active' : '' }}">👤 User</a>
        <a href="/kategoris" class="nav-link-btn {{ request()->is('kategoris*') ? 'active' : '' }}">📂 Kategori</a>
        <a href="/produks"   class="nav-link-btn {{ request()->is('produks*')   ? 'active' : '' }}">☕ Produk</a>
        <a href="/transaksis" class="nav-link-btn {{ request()->is('transaksis*') ? 'active' : '' }}">🧾 Transaksi</a>
        <a href="/laporans"  class="nav-link-btn {{ request()->is('laporans*')  ? 'active' : '' }}">📊 Laporan</a>
    </div>
</nav>

<div class="container mt-4 mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>