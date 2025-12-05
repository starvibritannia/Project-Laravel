<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tap Out - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Warna Merah Khusus Tap Out */
            --primary-glow: #f43f5e; /* Rose-500 */
            --secondary-glow: #ef4444; /* Red-500 */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(0, 0, 0, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at center, #31081f, #0f172a); /* Background merah gelap ke biru malam */
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
            filter: blur(90px);
            z-index: -1;
        }
        .shape-1 { background: var(--primary-glow); width: 350px; height: 350px; top: -100px; left: -50px; opacity: 0.3; }
        .shape-2 { background: #6366f1; width: 300px; height: 300px; bottom: -50px; right: -50px; opacity: 0.2; }

        /* Card Glassmorphism */
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Header Accent Line */
        .card-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-glow), var(--secondary-glow));
        }

        /* Input Styles */
        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--glass-border);
            color: #fff !important;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.4) !important;
            border-color: var(--primary-glow);
            box-shadow: 0 0 20px rgba(244, 63, 94, 0.25);
        }
        .form-control::placeholder { color: #888; }

        .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-right: none;
            color: #ccc;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        /* Tombol Tap Out (Merah Glowing) */
        .btn-tap-out {
            background: linear-gradient(135deg, var(--secondary-glow), #be123c);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transition: all 0.3s ease;
        }
        .btn-tap-out:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.6);
            color: white;
        }

        /* Tombol Kembali (Transparan) */
        .btn-back {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #cbd5e1;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* Alert Styling */
        .alert-glass {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 12px;
        }
        .alert-success-glass { border-left: 4px solid #10b981; }
        .alert-danger-glass { border-left: 4px solid #ef4444; }

        /* Icon Circle */
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.2), rgba(0,0,0,0));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(244, 63, 94, 0.3);
            box-shadow: 0 0 30px rgba(244, 63, 94, 0.1);
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                
                <div class="card card-glass">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-5">
                            <div class="icon-circle">
                                <i class="bi bi-door-open text-danger display-4"></i>
                            </div>
                            <h2 class="fw-bold mb-1 text-white">Tap Out</h2>
                            <p class="text-white-50 small">Selesaikan sesi kunjungan Anda</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-glass alert-success-glass alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-glass alert-danger-glass alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill text-danger me-3 fs-4"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('visit.tap-out-process') }}" method="POST">
                            @csrf 
                            
                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-bold small text-white-50">Identitas Pengunjung</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" name="visitor_id" class="form-control border-start-0" required placeholder="Masukkan NIM / ID Anda" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="d-grid gap-3 mt-5">
                                <button type="submit" class="btn btn-tap-out shadow-lg">
                                    SELESAIKAN KUNJUNGAN <i class="bi bi-box-arrow-right ms-2"></i>
                                </button>
                                
                                <a href="{{ route('visit.create') }}" class="btn btn-back text-decoration-none text-center">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Halaman Utama
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

</body>
</html>