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
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="password" name="password" 
                                   style="width: 100%; padding: 0.8rem; padding-right: 2.5rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);">
                            <button type="button" onclick="const i=this.previousElementSibling;const h=i.type==='password';i.type=h?'text':'password';this.querySelector('svg').style.display=h?'none':'block';this.querySelector('svg.off').style.display=h?'block':'none';" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: var(--text-secondary); padding: 0; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="off" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="cta-btn" style="width: 100%; border: none; font-size: 1rem;">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
