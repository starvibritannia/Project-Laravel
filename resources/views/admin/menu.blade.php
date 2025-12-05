<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Tema Ungu/Indigo (Admin Theme) */
            --admin-glow: #8b5cf6;
            --accent-glow: #3b82f6;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Background Gelap dengan Aksen Pusat */
            background: radial-gradient(circle at center, #1e1b4b, #020617);
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navbar Glass */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }

        /* Background Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            z-index: -1;
        }
        .shape-1 { background: var(--admin-glow); width: 400px; height: 400px; top: 10%; left: 20%; opacity: 0.2; }
        .shape-2 { background: var(--accent-glow); width: 350px; height: 350px; bottom: 10%; right: 20%; opacity: 0.15; }

        /* Card Menu Styles */
        .menu-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Efek Bouncy */
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .menu-card:hover {
            transform: translateY(-15px);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Icon Container */
        .icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 2.5rem;
            transition: transform 0.4s;
        }
        
        .menu-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        /* Warna Khusus Menu */
        .card-inventory .icon-wrapper {
            background: rgba(14, 165, 233, 0.1);
            color: #38bdf8; /* Sky Blue */
            box-shadow: 0 0 30px rgba(14, 165, 233, 0.2);
        }
        .card-monitor .icon-wrapper {
            background: rgba(16, 185, 129, 0.1);
            color: #34d399; /* Emerald Green */
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
        }

        /* Tombol Aksi dalam Card */
        .btn-action {
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: auto; /* Push ke bawah */
            border: none;
            transition: all 0.3s;
        }
        
        .btn-inventory {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
        }
        .btn-inventory:hover { box-shadow: 0 0 15px rgba(14, 165, 233, 0.5); transform: translateY(-2px); }

        .btn-monitor {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        .btn-monitor:hover { box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); transform: translateY(-2px); }

        /* Logout Button Style */
        .btn-logout {
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: rgba(220, 38, 38, 0.2);
            color: #fff;
            border-color: #ef4444;
        }
        
        /* Penyesuaian jarak dari navbar (menambah padding top pada container utama) */
        .min-vh-100 {
            padding-top: 100px; /* Memberikan ruang ekstra untuk navbar fixed */
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top py-3">
        <div class="container">
            <span class="navbar-brand fw-bold d-flex align-items-center">
                <i class="bi bi-shield-lock-fill me-2 fs-4 text-info"></i> 
                Admin Panel
            </span>
            
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button class="btn btn-logout btn-sm rounded-pill px-4 py-2 fw-bold">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container d-flex flex-column justify-content-center min-vh-100">
        
        <div class="text-center mb-5 pb-2 mt-5 animate-up">
            <h1 class="fw-bold display-5 mb-2">Selamat Datang, Admin!</h1>
            <p class="text-white-50 fs-5">Pusat Kendali Laboratorium IoT</p>
        </div>

        <div class="row justify-content-center g-4 px-lg-5">
            
            <div class="col-md-6 col-lg-5 col-xl-4">
                <a href="{{ route('items.index') }}" class="text-decoration-none">
                    <div class="menu-card card-inventory">
                        <div class="icon-wrapper">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-3">Inventaris</h3>
                        <p class="text-white-50 mb-4">
                            Kelola data alat, update stok, tambah barang baru, atau hapus aset rusak.
                        </p>
                        <button class="btn btn-action btn-inventory">
                            Buka Inventaris <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                    <div class="menu-card card-monitor">
                        <div class="icon-wrapper">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-3">Monitoring</h3>
                        <p class="text-white-50 mb-4">
                            Pantau aktivitas kunjungan, peminjaman barang, dan statistik harian.
                        </p>
                        <button class="btn btn-action btn-monitor">
                            Buka Dashboard <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </a>
            </div>

        </div>

        <div class="text-center mt-5 text-white-50">
            <small>&copy; {{ date('Y') }} IoTrack Management System</small>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>