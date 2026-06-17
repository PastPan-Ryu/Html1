@extends('layouts.app')

@section('title', 'My Profile - Game Vault')

@section('content')
    <div style="padding: 2rem; min-height: 80vh;">
        <div class="container" style="max-width: 1000px; padding: 0;">
            <div class="profile-header" style="background: var(--bg-card); padding: 2rem; border-radius: 12px; display: flex; align-items: center; gap: 2rem; margin-bottom: 3rem;">
                <div class="profile-avatar" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 4px solid var(--primary);">
                    <img src="{{ Auth::user()->foto ? asset('uploads/profiles/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.Auth::user()->username.'&background=0A2540&color=fff&size=120' }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="profile-info">
                    <h2 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 2rem;">{{ Auth::user()->username }}</h2>
                    <p style="color: var(--text-light); margin-bottom: 1rem;">Joined since {{ Auth::user()->created_at->format('M Y') }}</p>
                    <div style="display: flex; gap: 2rem;">
                        <div style="text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary);">{{ $totalIklan }}</div>
                            <div style="font-size: 0.9rem; color: var(--text-light);">Active Posts</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: bold; color: #27ae60;">{{ $totalTerjual }}</div>
                            <div style="font-size: 0.9rem; color: var(--text-light);">Sold Accounts</div>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: var(--danger); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; margin-bottom: 3rem;">
                <h3 style="color: var(--text-primary); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Edit Profile</h3>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="foto" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Profile Picture</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                               style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="username" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" required 
                               style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                               style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">New Password <span style="font-size: 0.8rem; color: var(--text-light);">(Leave blank to keep current)</span></label>
                        <input type="password" id="password" name="password" 
                               style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);">
                    </div>

                    <button type="submit" class="cta-btn" style="width: 100%; border: none; font-size: 1rem;">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
