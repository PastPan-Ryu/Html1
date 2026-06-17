<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard - Game Vault</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/favicon-vault.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="auth-dashboard">
        <!-- Left Side: Branding -->
        <div class="auth-left">
            <!-- Text removed as requested -->
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
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.8rem; padding-right: 2.5rem; border: 1px solid var(--border); border-radius: 8px;">
                            <button type="button" id="togglePassword" onclick="const input = document.getElementById('password'); const isHidden = input.type === 'password'; input.type = isHidden ? 'text' : 'password'; this.innerHTML = isHidden ? '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94\'/><path d=\'M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19\'/><line x1=\'1\' y1=\'1\' x2=\'23\' y2=\'23\'/></svg>' : '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z\'/><circle cx=\'12\' cy=\'12\' r=\'3\'/></svg>';" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: var(--text-secondary); padding: 0; display: flex; align-items: center;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
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
