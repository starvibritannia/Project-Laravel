<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin - Lab IoT</title>
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .navbar-custom { background-color: #343a40; }
        .hover-effect { transition: transform 0.3s, box-shadow 0.3s; }
        .hover-effect:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
        .card-icon { font-size: 5rem; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark navbar-custom shadow-sm mb-4 sticky-top">
    <div class="container">
        <span class="navbar-brand mb-0 h1 fw-bold d-flex align-items-center">
            <i class="bi bi-shield-lock-fill me-2 fs-4"></i> Admin Panel
        </span>
        
        <form action="{{ route('logout') }}" method="POST" class="d-flex">
            @csrf
            <button class="btn btn-outline-danger btn-sm fw-bold px-3">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="text-center mb-5 py-3">
        <h2 class="fw-bold display-6">Selamat Datang, Admin! 👋</h2>
        <p class="lead text-muted">Silahkan pilih menu pengelolaan sistem.</p>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-5 col-lg-4">
            <a href="{{ route('items.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg text-center p-5 hover-effect border-0 rounded-4" style="background: linear-gradient(145deg, #ffffff, #f0f2f5);">
                    <div class="card-body">
                        <i class="bi bi-box-seam-fill text-primary card-icon mb-4 d-block"></i>
                        <h4 class="fw-bold text-dark mb-3">Kelola Inventaris</h4>
                        <p class="text-muted mb-4">Tambah alat baru, update stok, atau hapus barang rusak.</p>
                        <button class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">Buka Inventaris</button>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-5 col-lg-4">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg text-center p-5 hover-effect border-0 rounded-4" style="background: linear-gradient(145deg, #ffffff, #f0f2f5);">
                    <div class="card-body">
                        <i class="bi bi-people text-success card-icon mb-4 d-block"></i>
                        <h4 class="fw-bold text-dark mb-3">Pantau Pengunjung</h4>
                        <p class="text-muted mb-4">Lihat aktivitas kunjungan dan proses pengembalian barang.</p>
                        <button class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow-sm">Buka Dashboard</button>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>