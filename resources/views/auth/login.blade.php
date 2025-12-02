<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Lab IoT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-login { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; width: 100%; max-width: 400px; }
        .header-login { background: #343a40; color: white; padding: 20px; text-align: center; }
    </style>
</head>
<body>
<div class="card card-login">
    <div class="header-login">
        <h4 class="mb-0">🔒 Login Admin</h4>
    </div>
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">Masuk Dashboard</button>
                <a href="/" class="btn btn-outline-secondary">Kembali ke Tap In</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>