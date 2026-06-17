<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Game Vault')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/favicon-vault.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <script>
        // Check theme before body renders to prevent flash
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light-mode-pre');
        }
    </script>
</head>
<body class="">
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
        }
    </script>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-logo">
            <img src="{{ asset('images/logo-gamevault.png') }}" alt="Game Vault Logo">
        </a>

        <div class="sidebar-section">GAMES</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') && !request('game') ? 'active' : '' }}">All Games</a></li>
        </ul>

        <div class="sidebar-section">CATEGORIES</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home', ['game' => 'Mobile Legends']) }}" class="{{ request('game') == 'Mobile Legends' ? 'active' : '' }}">Mobile Legends</a></li>
            <li><a href="{{ route('home', ['game' => 'Free Fire']) }}" class="{{ request('game') == 'Free Fire' ? 'active' : '' }}">Free Fire</a></li>
            <li><a href="{{ route('home', ['game' => 'PUBG Mobile']) }}" class="{{ request('game') == 'PUBG Mobile' ? 'active' : '' }}">PUBG Mobile</a></li>
            <li><a href="{{ route('home', ['game' => 'Valorant']) }}" class="{{ request('game') == 'Valorant' ? 'active' : '' }}">Valorant</a></li>
        </ul>

        <div class="sidebar-section">ACCOUNT</div>
        <ul class="sidebar-menu">
            @auth
            <li><a href="{{ route('myposts') }}" class="{{ request()->routeIs('myposts') || request()->routeIs('jualakun') ? 'active' : '' }}">Post Account</a></li>
            <li><a href="{{ route('mygames') }}" class="{{ request()->routeIs('mygames') ? 'active' : '' }}">My Games</a></li>
            <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">My Profile</a></li>
            @endauth
        </ul>

        <div style="margin-top: auto; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; color: var(--text-secondary); font-size: 0.9rem;">
            <span id="themeLabel">Dark mode</span>
            <div id="themeToggle" class="theme-toggle" style="width: 35px; height: 18px; background: var(--accent); border-radius: 10px; position: relative; cursor:pointer;">
                <div class="toggle-circle" style="width: 14px; height: 14px; background: white; border-radius: 50%; position: absolute; right: 2px; top: 2px;"></div>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="top-nav-links">
                <a href="#">FAQ</a>
                <a href="#">About</a>
                <a href="#">Support</a>
                <a href="#">🇬🇧 Eng ▾</a>
            </div>

            <div style="display:flex; align-items:center; gap: 1rem;">
                <a href="{{ route('topup') }}" style="background: var(--bg-card); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; display: flex; align-items: center; gap: 10px; text-decoration: none; transition: background 0.2s;">
                    <span style="color:var(--accent);"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ Auth::check() ? number_format(Auth::user()->points, 0, ',', '.') : '0' }} +</span>
                </a>

                <div class="nav-profile">
                    @auth
                        <a href="{{ route('profile') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none; cursor:pointer;">
                            <img src="{{ Auth::user()->foto ? asset('uploads/profiles/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.Auth::user()->username.'&background=7289da&color=fff' }}" alt="Profile" class="nav-avatar" style="object-fit: cover;">
                            <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                <span class="nav-username">{{ Auth::user()->username }} <span style="background:var(--accent); font-size:0.6rem; padding:1px 4px; border-radius:4px; color:white;">PRO</span></span>
                                <span style="font-size:0.7rem; color:var(--success);">● Online</span>
                            </div>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin-left:10px;">
                            @csrf
                            <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="cta-btn" style="padding: 4px 15px; font-size:0.9rem;">Login</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
