<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-glow: #3b82f6; /* Blue */
            --accent-glow: #06b6d4; /* Cyan */
            --glass-bg: rgba(30, 41, 59, 0.7); /* Slate 800 semi-transparent */
            --glass-border: rgba(255, 255, 255, 0.1);
            --dark-bg: #0f172a; /* Slate 900 */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: #e2e8f0;
            min-height: 100vh;
        }

        /* Navbar Glass */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
        }

        /* Action Bar (Search & Add) */
        .action-bar {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Inventory Card */
        .inv-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .inv-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            border-color: rgba(59, 130, 246, 0.4);
        }

        .card-img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .inv-card:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Stok Badge Overlay */
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.75rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            backdrop-filter: blur(4px);
        }
        .stock-success { background: rgba(16, 185, 129, 0.9); color: white; } /* Green */
        .stock-danger { background: rgba(239, 68, 68, 0.9); color: white; } /* Red */

        /* Description Text */
        .item-desc {
            color: #94a3b8;
            font-size: 0.9rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.7rem;
        }

        /* Custom Buttons */
        .btn-add-new {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s;
        }
        .btn-add-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.6);
            color: white;
        }

        .btn-edit-glow {
            border: 1px solid rgba(245, 158, 11, 0.5);
            color: #fbbf24;
            background: rgba(245, 158, 11, 0.1);
        }
        .btn-edit-glow:hover {
            background: #fbbf24;
            color: #000;
        }

        .btn-delete-glow {
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #f87171;
            background: rgba(239, 68, 68, 0.1);
        }
        .btn-delete-glow:hover {
            background: #ef4444;
            color: white;
        }

        /* Modal Styling */
        .modal-content {
            background-color: #1e293b;
            color: #fff;
            border: 1px solid var(--glass-border);
        }
        .modal-header, .modal-footer {
            border-color: var(--glass-border);
        }
        .btn-close { filter: invert(1); }
        
        .form-control, .form-control:focus {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top py-3">
        <div class="container">
            <span class="navbar-brand fw-bold d-flex align-items-center">
                <i class="bi bi-box-seam-fill me-2 text-primary"></i> 
                Inventaris Lab IoT
            </span>
            
            <a href="{{ route('admin.menu') }}" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
            </a>
        </div>
    </nav>

    <div class="container py-5 mt-5">

        <div class="action-bar p-4 mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0">
                <h4 class="fw-bold text-white mb-1">Daftar Alat & Komponen</h4>
                <p class="text-white-50 mb-0 small">
                    <i class="bi bi-database me-1"></i> Total Aset: <span class="text-white fw-bold">{{ count($items) }}</span> Jenis Barang
                </p>
            </div>
            
            <button type="button" class="btn btn-add-new" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-25 text-white border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger bg-danger bg-opacity-25 text-white border-0 shadow-sm mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach($items as $item)
            <div class="col">
                <div class="inv-card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                        
                        @if($item->current_stock > 0)
                            <span class="stock-badge stock-success">
                                <i class="bi bi-check-circle me-1"></i> Tersedia: {{ $item->current_stock }}
                            </span>
                        @else
                            <span class="stock-badge stock-danger">
                                <i class="bi bi-x-circle me-1"></i> Habis
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-white mb-2">{{ $item->name }}</h5>
                        
                        <p class="card-text item-desc mb-4" title="{{ $item->description }}">
                            {{ $item->description }}
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                                <span class="text-white-50 small">Total Aset</span>
                                <span class="fw-bold font-monospace text-white">{{ $item->total_stock }} Unit</span>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-edit-glow btn-sm flex-grow-1 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <button type="button" class="btn btn-delete-glow btn-sm flex-grow-1 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-header bg-primary text-white border-0">
                                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Barang</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail bg-dark border-secondary" style="height: 120px; object-fit: cover;">
                                    <p class="text-white-50 small mt-2">Gambar Saat Ini</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-info small fw-bold">GANTI GAMBAR</label>
                                    <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-info small fw-bold">NAMA BARANG</label>
                                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-info small fw-bold">DESKRIPSI</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-info small fw-bold">TOTAL ASET</label>
                                        <input type="number" name="total_stock" class="form-control" value="{{ $item->total_stock }}" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-warning small fw-bold">STOK TERSEDIA</label>
                                        <input type="number" name="current_stock" class="form-control" value="{{ $item->current_stock }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 justify-content-between">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-danger text-white border-0">
                            <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i> Hapus Barang?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-trash3-fill display-4"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Konfirmasi Hapus</h5>
                            <p class="text-white-50">
                                Anda akan menghapus <strong>{{ $item->name }}</strong> beserta gambarnya secara permanen.
                            </p>
                        </div>
                        <div class="modal-footer border-0 justify-content-center pb-4">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4 fw-bold">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white border-0">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Barang Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-success small fw-bold">UPLOAD FOTO (WAJIB)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-success small fw-bold">NAMA BARANG</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: ESP32 DevKit V1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-success small fw-bold">DESKRIPSI SINGKAT</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Spesifikasi alat..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-success small fw-bold">JUMLAH STOK AWAL</label>
                            <input type="number" name="total_stock" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>