<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-iot: #0d6efd;
            --accent-iot: #10b981;
            --warning-iot: #f59e0b;
            --danger-iot: #ef4444;
            --dark-bg: #0f172a; 
            --card-bg: rgba(30, 41, 59, 0.7); 
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: #f8fafc;
            min-height: 100vh;
            padding-bottom: 50px; /* Ruang untuk scroll */
        }

        /* Navbar Dark Glass */
        .navbar-custom { 
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        /* Header Card */
        .welcome-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .date-display {
            font-family: 'Roboto Mono', monospace;
            color: var(--accent-iot);
        }

        /* Stat Card */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            transition: all 0.3s;
            backdrop-filter: blur(8px);
        }
        .stat-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .stat-icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            font-size: 2rem;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .stat-borrowing .stat-icon-box { color: var(--warning-iot); }
        .stat-visitor .stat-icon-box { color: var(--accent-iot); }
        
        /* Table CSS Fixes */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            overflow: hidden;
            backdrop-filter: blur(8px);
        }
        .table-card .card-header {
            background-color: rgba(30, 41, 59, 0.9);
            border-bottom: 1px solid var(--border-color);
        }

        .table {
            --bs-table-bg: transparent; 
            --bs-table-color: #e2e8f0;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
            --bs-table-hover-color: #fff;
            margin-bottom: 0;
        }
        
        .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #e2e8f0;
            border-bottom-color: var(--border-color);
        }

        .table thead th {
            background-color: rgba(15, 23, 42, 0.5) !important;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-color);
        }

        /* Badges */
        .badge-borrowing {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid #fbbf24;
            font-weight: 600;
        }
        .badge-returned {
            background-color: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid #34d399;
            font-weight: 600;
        }
        .badge-study {
            background-color: rgba(14, 165, 233, 0.2);
            color: #38bdf8; 
            border: 1px solid #38bdf8;
            font-weight: 600;
        }

        /* Buttons */
        .btn-link-dark { color: var(--danger-iot); }
        .btn-link-dark:hover { color: #dc2626; }
        
        .btn-primary-glow {
            background-color: var(--primary-iot);
            border: none;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
            color: white;
        }
        .btn-primary-glow:hover {
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.7);
            background-color: #0b5ed7;
            color: white;
        }

        /* Modal Dark Theme */
        .modal-content {
            background-color: #1e293b;
            color: #fff;
            border: 1px solid var(--border-color);
        }
        .modal-header, .modal-footer {
            border-color: var(--border-color);
        }
        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark navbar-custom shadow-lg sticky-top py-3">
    <div class="container-fluid px-4 px-lg-5">
        <span class="navbar-brand mb-0 h1 fw-bold text-white">
            <i class="bi bi-speedometer2 me-2 text-accent-iot"></i> Monitoring Lab IoT
        </span>
        
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-light btn-sm rounded-pill px-4 py-2 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Menu
        </a>
    </div>
</nav>

<div class="container-fluid py-5 px-4 px-lg-5">

    {{-- HEADER & STATS --}}
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <div class="p-4 p-md-5 welcome-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-white mb-2">Halo, Admin!</h2>
                    <p class="text-white-50 mb-0 fs-5">Ringkasan aktivitas pemantauan Lab IoT.</p>
                </div>
                <div class="text-md-end text-center mt-3 mt-md-0">
                    <small class="text-white-50 d-block text-uppercase fw-semibold">Waktu Lokal Saat Ini</small>
                    <span class="fw-bold fs-4 date-display">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card stat-borrowing shadow-lg h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-box me-4">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <h6 class="text-warning-iot mb-1 small text-uppercase fw-bold" style="color: var(--warning-iot)">Sedang Dipinjam</h6>
                        <h3 class="fw-bold mb-0 text-white">{{ $activeBorrowings->count() }} <small class="fs-6 text-white-50">Item</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card stat-visitor shadow-lg h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-box me-4">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h6 class="text-accent-iot mb-1 small text-uppercase fw-bold" style="color: var(--accent-iot)">Pengunjung Hari Ini</h6>
                        <h3 class="fw-bold mb-0 text-white">{{ $uniqueVisitorsCount ?? $todaysVisits->count() }} <small class="fs-6 text-white-50">Orang</small></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-lg bg-success bg-opacity-25 text-white border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-lg bg-danger bg-opacity-25 text-white border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row g-5">
        
        {{-- TABEL 1: BARANG BELUM DIKEMBALIKAN --}}
        <div class="col-lg-12">
            <div class="card table-card shadow-lg">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-4"></i>
                    <h5 class="m-0 fw-bold text-white">Barang Belum Dikembalikan</h5>
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
                                        <div class="fw-bold text-white">{{ $borrow->visit->visitor_name }}</div>
                                        <small class="text-white-50">{{ $borrow->visit->visitor_id }}</small>
                                    </td>
                                    <td>
                                        @if($borrow->item)
                                            <span class="text-info fw-semibold">{{ $borrow->item->name }}</span>
                                        @else
                                            <span class="text-danger fw-semibold">[Item hilang]</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary text-white rounded-pill">{{ $borrow->quantity }} Unit</span></td>
                                    <td>
                                        <div class="text-white-50"><i class="bi bi-clock me-1"></i> {{ $borrow->created_at->format('H:i') }}</div>
                                        <small class="text-white-50 opacity-75">{{ $borrow->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary-glow btn-sm rounded-pill px-4" 
                                                data-bs-toggle="modal" data-bs-target="#returnModal{{ $borrow->id }}">
                                            <i class="bi bi-box-arrow-in-down me-1"></i> Terima
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-white-50">
                                        <i class="bi bi-check-circle display-4 d-block mb-3 text-accent-iot opacity-50"></i>
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

        {{-- TABEL 2: RIWAYAT KUNJUNGAN --}}
        <div class="col-lg-12">
            <div class="card table-card shadow-lg">
                <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <i class="bi bi-journal-text text-primary-iot me-3 fs-4"></i>
                        <h5 class="m-0 fw-bold text-white">Riwayat Kunjungan Hari Ini</h5>
                    </div>

                    <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                        <span class="small text-white-50">Filter:</span>
                        @php $activityFilter = $activityFilter ?? request('activity'); @endphp
                        <select name="activity" class="form-select form-select-sm bg-dark text-white border-secondary" style="width: auto;" onchange="this.form.submit()">
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
                                    <th class="ps-4">Jam Masuk</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todaysVisits as $visit)
                                <tr>
                                    <td class="ps-4 fw-bold text-info">{{ $visit->created_at->format('H:i') }} <span class="small text-white-50">WIB</span></td>
                                    <td class="fw-semibold text-white">{{ $visit->visitor_name }}</td>
                                    <td class="text-white-50 font-monospace small">{{ $visit->visitor_id }}</td>
                                    <td>
                                        @if($visit->purpose === 'belajar')
                                            <span class="badge badge-study px-3 py-2"><i class="bi bi-book me-1"></i> Belajar Saja</span>
                                        @elseif($visit->purpose === 'pinjam')
                                            @php
                                                $borrowedItems = $visit->borrowings->map(function ($b) {
                                                    $itemName = optional($b->item)->name ?? 'Item Dihapus';
                                                    return $itemName.' ('.$b->quantity.'x)';
                                                })->implode(', ');
                                            @endphp
                                            <span class="badge badge-borrowing px-3 py-2 text-start text-wrap"><i class="bi bi-tools me-1"></i> Pinjam: {{ $borrowedItems }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($visit->purpose === 'belajar')
                                            <span class="text-white-50">-</span>
                                        @else
                                            @if($visit->borrowings->contains('status', 'dipinjam'))
                                                <span class="badge bg-warning text-dark rounded-pill">Dipinjam</span>
                                            @else
                                                <span class="badge badge-returned rounded-pill">Selesai</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link btn-link-dark p-0" 
                                                data-bs-toggle="modal" data-bs-target="#deleteVisitModal{{ $visit->id }}" 
                                                title="Hapus Riwayat">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-white-50">
                                        <i class="bi bi-battery display-4 d-block mb-3 text-white-50 opacity-50"></i>
                                        Belum ada pengunjung tercatat hari ini.
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

{{-- 
================================================================
BAGIAN MODAL (Diletakkan di luar tabel agar tidak error z-index)
================================================================ 
--}}

{{-- 1. Loop Modal Terima Barang --}}
@foreach($activeBorrowings as $borrow)
<div class="modal fade" id="returnModal{{ $borrow->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i> Konfirmasi Pengembalian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-check-lg display-4"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-3 text-white">Terima Barang Kembali?</h5>
                <p class="text-white-50 mb-0">
                    Anda akan menerima <strong>{{ $borrow->quantity }} unit {{ optional($borrow->item)->name }}</strong> 
                    dari <strong>{{ $borrow->visit->visitor_name }}</strong>.
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4">
                <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.return', $borrow->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Ya, Terima</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- 2. Loop Modal Hapus Riwayat --}}
@foreach($todaysVisits as $visit)
<div class="modal fade" id="deleteVisitModal{{ $visit->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i> Hapus Riwayat?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-3"><i class="bi bi-trash-fill text-danger display-3"></i></div>
                <h5 class="fw-bold mb-3 text-white">Konfirmasi Penghapusan</h5>
                <p class="text-white-50 mb-0">
                    Hapus riwayat <strong>{{ $visit->visitor_name }}</strong>?<br>
                    <small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4">
                <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.visit.destroy', $visit->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>