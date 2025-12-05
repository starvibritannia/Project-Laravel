<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --success-glow: #10b981; /* Emerald Green */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at center, #064e3b, #020617); /* Hijau tua ke Hitam */
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
            animation: float 6s ease-in-out infinite;
        }
        .shape-1 { background: var(--success-glow); width: 300px; height: 300px; top: -50px; left: -50px; opacity: 0.2; }
        .shape-2 { background: #0ea5e9; width: 400px; height: 400px; bottom: -100px; right: -100px; opacity: 0.15; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(20px); }
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

        /* Success Icon Animation */
        .icon-container {
            width: 100px;
            height: 100px;
            background: rgba(16, 185, 129, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.4);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Typography */
        .visitor-name {
            font-family: 'JetBrains Mono', monospace; /* Font coding */
            background: rgba(0, 0, 0, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid var(--success-glow);
            color: var(--success-glow);
            display: inline-block;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        /* Buttons */
        .btn-home {
            background: var(--success-glow);
            color: #020617;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .btn-home:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
            background: #34d399;
        }

        .btn-outline-light-custom {
            border: 1px solid rgba(255,255,255,0.3);
            color: #ccc;
            border-radius: 50px;
            padding: 12px 25px;
            transition: all 0.3s;
        }
        .btn-outline-light-custom:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: #fff;
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

                        {{-- Animated Success Icon --}}
                        <div class="icon-container">
                            <i class="bi bi-check-lg display-3 text-success"></i>
                        </div>

                        {{-- Judul --}}
                        <h2 class="fw-bold mb-2">Selamat Datang!</h2>
                        <p class="text-white-50 mb-4">Akses Lab IoT Berhasil Dikonfirmasi</p>

                        {{-- Nama Pengunjung (Style ala ID Card Digital) --}}
                        <div>
                            <h4 class="visitor-name">
                                {{ $visit->visitor_name }}
                            </h4>
                        </div>

                        {{-- Pesan --}}
                        <p class="mb-4 text-light opacity-75">
                            Silakan masuk dan beraktivitas. <br>
                            <span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i> Jangan lupa jaga kebersihan & keamanan alat.</span>
                        </p>

                        {{-- Tombol Navigasi --}}
                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                            <a href="{{ route('visit.create') }}" class="btn btn-home text-decoration-none">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Kembali ke Tap In
                            </a>
                            
                            <a href="{{ route('visit.tap-out') }}" class="btn btn-outline-light-custom text-decoration-none">
                                <i class="bi bi-door-open me-1"></i> Tap Out
                            </a>
                        </div>

                    </div>
                    
                    {{-- Footer kecil di dalam kartu --}}
                    <div class="mt-4 pt-3 border-top border-secondary border-opacity-25">
                        <small class="text-white-50" style="font-size: 0.75rem;">
                            {{ now()->format('l, d F Y • H:i') }} WIB
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>