<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard - Game Vault</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="auth-dashboard">
        <!-- Left Side: Branding -->
        <div class="auth-left">
            <h1>🎮 Game Vault</h1>
            <p style="font-size: 1.2rem; max-width: 80%;">Selamat datang kembali! Masuk untuk mengelola iklan akun game Anda atau menemukan akun idaman.</p>
        </div>
        
        <!-- Right Side: Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <a href="{{ route('home') }}" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem; margin-bottom: 20px; display: inline-block;">&larr; Kembali ke Beranda</a>
                <h2>Masuk ke Dashboard</h2>
                
                @if ($errors->any())
                    <div style="background: #e74c3c; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <ul style="margin-left: 1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group" style="text-align: left; margin-bottom: 1.2rem;">
                        <label for="username" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Username</label>
                        <input type="text" id="username" name="username" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('username') }}">
                    </div>
                    <div class="form-group" style="text-align: left; margin-bottom: 1.2rem;">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password</label>
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">
                    </div>
                    <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer;">Login</button>
                </form>
                <div style="margin-top: 1.5rem; color: var(--text-light); text-align: center;">
                    Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
