<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Barang - Lab IoT</title>
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Navbar Style (Sama dengan Dashboard) */
        .navbar-custom { background-color: #343a40; }
        
        /* Card Style */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        .item-description {
            font-size: 0.9rem;
            color: #6c757d;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.7rem; /* Menjaga tinggi deskripsi agar seragam */
        }
        .btn-action { width: 100%; }
        /* Hover effect untuk kartu */
        .hover-card {
            transition: transform 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark navbar-custom shadow-sm sticky-top">
    <div class="container">
        <span class="navbar-brand mb-0 h1 fw-bold">
            <i class="bi bi-box-seam-fill"></i> Inventaris Lab IoT
        </span>
        
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Menu
        </a>
    </div>
</nav>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded shadow-sm border">
        <div>
            <h5 class="fw-bold text-dark mb-0">Daftar Alat & Komponen</h5>
            <small class="text-muted">Total {{ count($items) }} jenis barang terdaftar</small>
        </div>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Barang Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($items as $item)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold text-primary">{{ $item->name }}</h5>
                        <span class="badge {{ $item->current_stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                            {{ $item->current_stock }} Tersedia
                        </span>
                    </div>
                    
                    <p class="card-text item-description mb-3" title="{{ $item->description }}">
                        {{ $item->description }}
                    </p>

                    <div class="mt-auto">
                        <div class="text-muted small mb-3">
                            <i class="bi bi-layers-half"></i> Total Aset: <strong>{{ $item->total_stock }}</strong> Unit
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-warning btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit {{ $item->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail" style="height: 100px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ganti Gambar</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Total Aset</label>
                                    <input type="number" name="total_stock" class="form-control" value="{{ $item->total_stock }}" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Stok Tersedia</label>
                                    <input type="number" name="current_stock" class="form-control" value="{{ $item->current_stock }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Hapus Barang</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <i class="bi bi-trash text-danger display-4 mb-3"></i>
                        <h5>Hapus {{ $item->name }}?</h5>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan. Gambar dan data akan hilang.</p>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <div class="d-grid gap-2 col-8 mx-auto mt-4">
                                <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Barang Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Barang (Wajib)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Sensor DHT11" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan spesifikasi singkat..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Stok Awal</label>
                        <input type="number" name="total_stock" class="form-control" placeholder="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>