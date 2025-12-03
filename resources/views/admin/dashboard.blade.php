<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lab IoT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .navbar-custom { background-color: #343a40; }
        
        .stat-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); }

        .icon-box {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }

        .table-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark navbar-custom shadow-sm sticky-top">
    <div class="container">
        <span class="navbar-brand mb-0 h1 fw-bold">
            <i class="bi bi-speedometer2"></i> Dashboard Monitoring
        </span>
        
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Menu
        </a>
    </div>
</nav>

<div class="container py-4">

    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="p-4 bg-white rounded shadow-sm border d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Halo, Admin! 👋</h4>
                    <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas Lab IoT hari ini.</p>
                </div>
                <div class="text-end d-none d-md-block">
                    <small class="text-muted d-block">Tanggal Hari Ini</small>
                    <span class="fw-bold fs-5">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Sedang Dipinjam</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $activeBorrowings->count() }} <small class="fs-6 text-muted">Item</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase fw-bold">Pengunjung Hari Ini</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $uniqueVisitorsCount ?? $todaysVisits->count() }} <small class="fs-6 text-muted">Orang</small></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="row g-4">
        
        {{-- BARANG BELUM DIKEMBALIKAN --}}
        <div class="col-lg-12">
            <div class="card table-card">
                <div class="card-header bg-white py-3 d-flex align-items-center border-bottom">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2 fs-5"></i>
                    <h6 class="m-0 fw-bold text-dark">Barang Belum Dikembalikan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Peminjam</th>
                                    <th>Barang</th>
                                    <th>Qty</th>
                                    <th>Waktu Pinjam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeBorrowings as $borrow)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $borrow->visit->visitor_name }}</div>
                                        <small class="text-muted">{{ $borrow->visit->visitor_id }}</small>
                                    </td>
                                    <td>
                                        @if($borrow->item)
                                            <span class="text-primary fw-semibold">{{ $borrow->item->name }}</span>
                                        @else
                                            <span class="text-danger fw-semibold">[Item hilang]</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary rounded-pill">{{ $borrow->quantity }} Unit</span></td>
                                    <td>
                                        <i class="bi bi-clock text-muted"></i> {{ $borrow->created_at->format('H:i') }}
                                        <small class="text-muted d-block">{{ $borrow->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" 
                                                data-bs-toggle="modal" data-bs-target="#returnModal{{ $borrow->id }}">
                                            <i class="bi bi-box-arrow-in-down me-1"></i> Terima
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="returnModal{{ $borrow->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i> Konfirmasi Pengembalian</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center p-4">
                                                <div class="mb-3">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                        <i class="bi bi-check-lg display-4"></i>
                                                    </div>
                                                </div>
                                                <h5 class="fw-bold mb-3">Terima Barang Kembali?</h5>
                                                <p class="text-muted mb-0">
                                                    Anda akan menerima <strong>{{ $borrow->quantity }} unit {{ $borrow->item->name }}</strong> 
                                                    dari <strong>{{ $borrow->visit->visitor_name }}</strong>.
                                                </p>
                                            </div>
                                            <div class="modal-footer bg-light justify-content-center border-0 pb-4">
                                                <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.return', $borrow->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                                        <i class="bi bi-box-arrow-in-down me-2"></i> Ya, Terima Barang
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-check-circle display-4 d-block mb-3 text-success opacity-50"></i>
                                        Tidak ada barang yang sedang dipinjam saat ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIWAYAT KUNJUNGAN HARI INI --}}
        <div class="col-lg-12">
            <div class="card table-card">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <i class="bi bi-journal-text text-primary me-2 fs-5"></i>
                        <h6 class="m-0 fw-bold text-dark">Riwayat Kunjungan Hari Ini</h6>
                    </div>

                    {{-- FILTER AKTIVITAS --}}
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                        <span class="small text-muted">Filter aktivitas:</span>
                        @php $activityFilter = $activityFilter ?? request('activity'); @endphp
                        <select name="activity" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="" {{ $activityFilter == null ? 'selected' : '' }}>Semua</option>
                            <option value="meminjam" {{ $activityFilter === 'meminjam' ? 'selected' : '' }}>Meminjam</option>
                            <option value="belajar" {{ $activityFilter === 'belajar' ? 'selected' : '' }}>Belajar saja</option>
                        </select>
                    </form>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width: 12%;">Jam Masuk</th>
                                    <th style="width: 22%;">Nama</th>
                                    <th style="width: 18%;">NIM</th>
                                    <th>Aktivitas</th>
                                    <th style="width: 18%;">Status Peminjaman</th>
                                    <th class="text-center" style="width: 8%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todaysVisits as $visit)
                                <tr>
                                    {{-- JAM --}}
                                    <td class="ps-4 fw-bold text-secondary">{{ $visit->created_at->format('H:i') }} WIB</td>

                                    {{-- NAMA --}}
                                    <td class="fw-semibold">{{ $visit->visitor_name }}</td>

                                    {{-- NIM --}}
                                    <td class="text-muted font-monospace">{{ $visit->visitor_id }}</td>

                                    {{-- AKTIVITAS DETAIL --}}
                                    <td>
                                        @if($visit->purpose === 'belajar')
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                                <i class="bi bi-book me-1"></i> Belajar Saja
                                            </span>
                                        @elseif($visit->purpose === 'pinjam')
                                            @php
                                                // asumsi relasi: $visit->borrowings (hasMany)
                                                $borrowedItems = $visit->borrowings->map(function ($b) {
                                                    $itemName = optional($b->item)->name ?? 'Item Dihapus';
                                                    return $itemName.' ('.$b->quantity.'x)';
                                                })->implode(', ');
                                            @endphp

                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 text-start text-wrap" style="line-height: 1.4;">
                                                <i class="bi bi-tools me-1"></i>
                                                Pinjam: {{ $borrowedItems ?: 'Belum ada data peminjaman' }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS PEMINJAMAN --}}
                                    <td>
                                        @if($visit->purpose === 'belajar')
                                            <span class="text-muted">-</span>
                                        @else
                                            @php
                                                $hasActiveBorrowing = $visit->borrowings->contains('status', 'dipinjam');
                                            @endphp

                                            @if($hasActiveBorrowing)
                                                <span class="badge bg-warning text-dark rounded-pill">
                                                    Sedang dipinjam
                                                </span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill">
                                                    Selesai / Dikembalikan
                                                </span>
                                            @endif
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link text-danger p-0" 
                                                data-bs-toggle="modal" data-bs-target="#deleteVisitModal{{ $visit->id }}" 
                                                title="Hapus Riwayat">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- MODAL HAPUS --}}
                                <div class="modal fade" id="deleteVisitModal{{ $visit->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            
                                            <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Hapus Riwayat?
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body text-center p-4">
                                                <div class="mb-3">
                                                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                        <i class="bi bi-trash3-fill display-4"></i>
                                                    </div>
                                                </div>
                                                
                                                <h5 class="fw-bold mb-3">Konfirmasi Penghapusan</h5>
                                                
                                                <p class="text-muted mb-0">
                                                    Anda akan menghapus riwayat kunjungan dari: <br>
                                                    <strong>{{ $visit->visitor_name }}</strong> ({{ $visit->created_at->format('H:i') }} WIB).
                                                    <br><small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>
                                                </p>
                                            </div>

                                            <div class="modal-footer bg-light justify-content-center border-0 pb-4">
                                                <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                
                                                <form action="{{ route('admin.visit.destroy', $visit->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm">
                                                        <i class="bi bi-trash-fill me-2"></i> Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        Belum ada pengunjung hari ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
