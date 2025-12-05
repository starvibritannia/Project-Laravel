<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Tema Sunset/Warm untuk "Goodbye" */
            --warm-glow: #f43f5e; /* Rose */
            --warm-accent: #f97316; /* Orange */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at center, #2e1065, #020617); /* Ungu gelap ke Hitam */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
        }

        /* Background Animated Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }
        .shape-1 { background: var(--warm-glow); width: 350px; height: 350px; top: -80px; right: -80px; opacity: 0.25; }
        .shape-2 { background: var(--warm-accent); width: 300px; height: 300px; bottom: -80px; left: -80px; opacity: 0.2; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Card Glassmorphism */
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Header Accent Line */
        .card-glass::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--warm-glow), var(--warm-accent));
        }

        /* Icon Animation */
        .icon-container {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.2), rgba(249, 115, 22, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            border: 1px solid rgba(244, 63, 94, 0.3);
            box-shadow: 0 0 30px rgba(244, 63, 94, 0.3);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(244, 63, 94, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
        }

        /* Visitor Name Badge */
        .visitor-badge {
            font-family: 'JetBrains Mono', monospace;
            background: rgba(0, 0, 0, 0.3);
            padding: 12px 25px;
            border-radius: 10px;
            border-left: 4px solid var(--warm-glow);
            color: #fff;
            display: inline-block;
            margin-bottom: 25px;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        /* Buttons */
        .btn-home {
            background: linear-gradient(135deg, var(--warm-glow), var(--warm-accent));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.4);
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(244, 63, 94, 0.6);
            color: white;
        }

        .btn-outline-glass {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ddd;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                <div class="card card-glass p-4 p-md-5">
                    <div class="card-body">

                        {{-- Animated Wave Icon --}}
                        <div class="icon-container">
                            <i class="bi bi-hand-thumbs-up-fill display-3 text-white"></i>
                        </div>

                        {{-- Judul --}}
                        <h2 class="fw-bold mb-2 text-white">Terima Kasih!</h2>
                        <p class="text-white-50 mb-4">Sesi Kunjungan Telah Berakhir</p>

                        {{-- Nama Pengunjung --}}
                        <div>
                            <div class="visitor-badge">
                                {{ $name }}
                            </div>
                        </div>

                        {{-- Pesan Konfirmasi --}}
                        <p class="mb-4 text-light opacity-80">
                            Data peminjaman barang telah dikembalikan dan riwayat kunjungan Anda tersimpan.
                        </p>

                        {{-- Pesan Peringatan (Rapi) --}}
                        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-white d-flex align-items-center justify-content-center mb-4 py-3 rounded-3" style="backdrop-filter: blur(5px);">
                            <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                            <span class="small">Pastikan area kerja rapi dan aman sebelum meninggalkan lab.</span>
                        </div>

                        {{-- Tombol Navigasi --}}
                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                            <a href="{{ route('visit.create') }}" class="btn btn-outline-glass text-decoration-none">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Tap In Lagi
                            </a>
                            
                            <a href="{{ route('visit.tap-out') }}" class="btn btn-home text-decoration-none">
                                <i class="bi bi-person-check-fill me-1"></i> Tap Out Lainnya
                            </a>
                        </div>

                    </div>
                    
                    {{-- Footer --}}
                    <div class="mt-4 pt-3 border-top border-white border-opacity-10">
                        <small class="text-white-50">Sampai jumpa lagi di Lab IoT 👋</small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>