<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Lab IoT</title>
    
    {{-- LOGO TAB BROWSER (JANGAN DIHAPUS) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/IoTrackLogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Tema Admin / Security (Indigo/Ungu) */
            --primary-glow: #6366f1; /* Indigo */
            --secondary-glow: #8b5cf6; /* Violet */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(0, 0, 0, 0.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Background Gelap dengan Aksen Biru/Ungu */
            background: radial-gradient(circle at center, #1e1b4b, #0f0a28); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow-x: hidden;
        }

        /* Background Animated Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }
        .shape-1 { background: var(--primary-glow); width: 350px; height: 350px; top: -50px; left: -50px; opacity: 0.3; }
        .shape-2 { background: var(--secondary-glow); width: 300px; height: 300px; bottom: -50px; right: -50px; opacity: 0.2; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(15px); }
        }

        /* Card Glassmorphism */
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
            width: 100%; 
            max-width: 400px;
        }
        .card-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-glow), var(--secondary-glow));
        }

        /* Input Style */
        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--glass-border);
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 15px;
        }
        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.3) !important;
            border-color: var(--primary-glow);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
        }
        .form-control::placeholder { color: #888; }
        .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-right: none;
            color: #94a3b8;
        }

        /* Tombol Utama (Glowing) */
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
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.6);
            color: white;
        }

        /* Tombol Kembali (Outline Glass) */
        .btn-outline-glass {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ccc;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* Alert Styling */
        .alert-glass {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ffcccc;
            border-radius: 8px;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card card-glass position-relative">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-5">
                    <i class="bi bi-shield-lock-fill display-3" style="color: var(--primary-glow);"></i>
                    <h3 class="fw-bold mt-3 mb-1 text-white">Admin Access</h3>
                    <p class="text-white-50 small">IoTrack System Security</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-glass mb-4" role="alert">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-white-50">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required autofocus placeholder="Masukkan email">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label fw-semibold small text-white-50">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-glow shadow-lg">
                            <i class="bi bi-box-arrow-in-right me-1"></i> MASUK DASHBOARD
                        </button>
                        
                        <a href="/" class="btn btn-outline-glass text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Tap In
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>