<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tap In - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Tema Biru Laut / Cyber */
            --primary-glow: #0ea5e9; /* Sky Blue */
            --secondary-glow: #3b82f6; /* Blue */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(0, 0, 0, 0.3); /* Input lebih gelap sedikit */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top right, #0f172a, #172554); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow-x: hidden;
        }

        /* Background Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }
        .shape-1 { background: var(--primary-glow); width: 300px; height: 300px; top: -50px; right: -50px; opacity: 0.3; }
        .shape-2 { background: #8b5cf6; width: 400px; height: 400px; bottom: -100px; left: -100px; opacity: 0.2; }

        /* Card Glassmorphism */
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        /* --- CUSTOM INPUT & SELECT STYLE (FIXED) --- */
        .form-control, .form-select {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--glass-border);
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 15px;
            font-weight: 500;
        }

        /* Style khusus untuk Dropdown (Select) */
        .form-select {
            /* Membuat panah dropdown menjadi putih agar terlihat */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            cursor: pointer;
        }

        /* Style untuk Pilihan (Option) di dalam Dropdown */
        .form-select option {
            background-color: #0f172a; /* Background Gelap Pekat */
            color: #fff; /* Teks Putih */
            padding: 10px;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(0, 0, 0, 0.5) !important;
            border-color: var(--primary-glow);
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.3);
            color: #fff !important;
        }
        
        .form-control::placeholder { color: #94a3b8; }
        
        .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-right: none;
            color: #38bdf8; /* Ikon warna biru muda */
        }
        /* ------------------------------------------ */

        /* Tombol Utama */
        .btn-glow {
            background: linear-gradient(135deg, var(--primary-glow), var(--secondary-glow));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
            color: white;
        }

        /* Tombol Admin */
        .btn-admin {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }
        .btn-admin:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        /* Animasi Kotak Peminjaman */
        #borrowDetailBox {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transform: translateY(-10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(0, 0, 0, 0.3); /* Lebih gelap dari card */
            border: 1px solid rgba(255,255,255,0.1);
        }
        #borrowDetailBox.active {
            max-height: 500px;
            opacity: 1;
            transform: translateY(0);
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="position-absolute top-0 end-0 p-4">
        <a href="{{ route('login') }}" class="btn btn-admin btn-sm rounded-pill px-3 py-2 text-decoration-none">
            <i class="bi bi-shield-lock-fill me-1"></i> Admin
        </a>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">

                <div class="card card-glass">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-4">
                            <div class="d-inline-block p-3 rounded-circle mb-3" style="background: rgba(255,255,255,0.05); box-shadow: 0 0 15px rgba(14, 165, 233, 0.2);">
                                <i class="bi bi-cpu fs-1 text-info"></i>
                            </div>
                            <h2 class="fw-bold mb-0 text-white" style="letter-spacing: 1px;">IoTrack</h2>
                            <p class="text-white-50 small">Sistem Pencatatan Lab IoT</p>
                        </div>

                        {{-- Alert Notifications --}}
                        @if(session('success'))
                            <div class="alert alert-success bg-success bg-opacity-25 text-white border-0 d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger bg-danger bg-opacity-25 text-white border-0 d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-danger border-opacity-25 mb-4">
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- FORM START --}}
                        <form action="{{ route('visit.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-bold small text-info" style="letter-spacing: 1px;">Identitas</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="visitor_id" name="visitor_id" value="{{ old('visitor_id') }}" required placeholder="Masukkan NIM Anda">
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <label class="form-label text-uppercase fw-bold small text-info" style="letter-spacing: 1px;">Tujuan</label>
                                <select name="purpose" id="purposeSelect" class="form-select">
                                    <option value="" selected disabled>-- Pilih Aktivitas --</option>
                                    <option value="belajar" {{ old('purpose') == 'belajar' ? 'selected' : '' }}>📚 Hanya Belajar / Berkunjung</option>
                                    <option value="pinjam" {{ old('purpose') == 'pinjam' ? 'selected' : '' }}>🛠️ Peminjaman Alat/Barang</option>
                                </select>
                            </div>

                            <div id="borrowDetailBox" class="rounded-3">
                                <div class="d-flex align-items-center mb-3 border-bottom border-secondary border-opacity-25 pb-2">
                                    <i class="bi bi-box-seam text-warning me-2"></i>
                                    <span class="fw-semibold text-white">Detail Peminjaman</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small text-white-50">Pilih Barang</label>
                                    <select name="item_id" id="itemSelect" class="form-select">
                                        <option value="">-- Cari Barang --</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }} (Sisa: {{ $item->current_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-1">
                                    <label class="form-label small text-white-50">Jumlah Unit</label>
                                    <input type="number" name="quantity" id="quantityInput" class="form-control" min="1" placeholder="0" value="{{ old('quantity', 1) }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-glow w-100 mt-5 shadow-lg py-3">
                                TAP IN SEKARANG <i class="bi bi-arrow-right-circle ms-2"></i>
                            </button>

                            <div class="text-center mt-4">
                                <a href="{{ route('visit.tap-out') }}" class="small text-white-50 text-decoration-none link-opacity-75-hover">
                                    <i class="bi bi-box-arrow-left me-1"></i> Ingin keluar? <span class="text-info fw-bold">Klik Tap Out</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-white-50 opacity-50">&copy; {{ date('Y') }} IoTrack System</small>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const purposeSelect  = document.getElementById('purposeSelect');
        const detailBox      = document.getElementById('borrowDetailBox');
        const itemSelect     = document.getElementById('itemSelect');
        const quantityInput  = document.getElementById('quantityInput');

        function showDetailBox() {
            detailBox.classList.add('active');
            itemSelect.required    = true;
            quantityInput.required = true;
        }

        function hideDetailBox() {
            detailBox.classList.remove('active');
            itemSelect.required    = false;
            quantityInput.required = false;
        }

        function toggleDetailBox() {
            if (!purposeSelect) return;
            if (purposeSelect.value === 'pinjam') {
                showDetailBox();
            } else {
                hideDetailBox();
            }
        }

        if (purposeSelect) {
            purposeSelect.addEventListener('change', toggleDetailBox);
        }

        toggleDetailBox();
    });
    </script>

</body>
</html>