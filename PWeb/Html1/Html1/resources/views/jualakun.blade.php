@extends('layouts.app')

@section('title', 'Sell Account - Game Vault')

@section('content')
    <div style="padding: 2rem;">
        <div style="margin: 0 auto; max-width: 700px; background: var(--bg-card); padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow);">
            <h2 style="text-align: center; color: var(--text-primary); margin-bottom: 2rem;">Start Selling Your Game Account</h2>
            
            @if ($errors->any())
                <div style="background: #e74c3c; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jualakun.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Name / In-Game Name</label>
                    <input type="text" name="nama_akun" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('nama_akun') }}">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Select Game</label>
                    <select name="game" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">
                        <option value="Mobile Legends" {{ old('game') == 'Mobile Legends' ? 'selected' : '' }}>Mobile Legends</option>
                        <option value="Free Fire" {{ old('game') == 'Free Fire' ? 'selected' : '' }}>Free Fire</option>
                        <option value="PUBG Mobile" {{ old('game') == 'PUBG Mobile' ? 'selected' : '' }}>PUBG Mobile</option>
                        <option value="Valorant" {{ old('game') == 'Valorant' ? 'selected' : '' }}>Valorant</option>
                        <option value="Lainnya" {{ old('game') == 'Lainnya' ? 'selected' : '' }}>Others...</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.2rem;">
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Level (Optional)</label>
                        <input type="number" name="level" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('level') }}">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Rank (Optional)</label>
                        <input type="text" name="rank" placeholder="Example: Mythic" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('rank') }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Price (Points) 💎 <span style="font-size: 0.8em; font-weight: normal; color: var(--text-light); margin-left: 5px;">(1 Point = Rp. 1000)</span></label>
                    <input type="number" name="harga" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('harga') }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">WhatsApp Contact Number</label>
                    <input type="text" name="kontak" required placeholder="Example: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('kontak') }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Proof Photo</label>
                    <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Short Description</label>
                    <textarea name="deskripsi" rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">{{ old('deskripsi') }}</textarea>
                </div>

                <div style="background: rgba(88, 101, 242, 0.1); padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(88, 101, 242, 0.3); margin-bottom: 2rem;">
                    <h4 style="margin-bottom: 1rem; color: var(--accent); display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Secure Account Delivery
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-light); margin-bottom: 1rem;">
                        The credentials below will be <strong>hidden from the public</strong> and only securely sent to the buyer after a successful purchase.
                    </p>
                    
                    <div class="form-group" style="margin-bottom: 1.2rem;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Game Login Email / Username</label>
                        <input type="text" name="login_email" required placeholder="Email or Username to login to the game" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main);" value="{{ old('login_email') }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Game Login Password</label>
                        <input type="password" name="login_password" required placeholder="Password to login to the game" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main);">
                    </div>
                </div>

                <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; font-size: 1.1rem;">Post Account</button>
            </form>
        </div>
    </div>
@endsection
