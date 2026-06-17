@extends('layouts.app')

@section('title', 'Checkout - Game Vault')

@section('content')
<div style="padding: 2rem; min-height: 80vh; display: flex; justify-content: center; align-items: flex-start;">
    <div style="width: 100%; max-width: 800px; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        
        <!-- Order Summary -->
        <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; border: 1px solid var(--border);">
            <h3 style="color: var(--text-primary); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Order Summary</h3>
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <img src="{{ ($akun->foto && count($akun->foto) > 0) ? asset('uploads/'.$akun->foto[0]) : 'https://ui-avatars.com/api/?name='.urlencode($akun->nama_akun).'&background=3282B8&color=fff&size=400' }}" alt="Game" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">
                <div>
                    <h4 style="color: var(--text-primary); margin-bottom: 0.2rem;">{{ $akun->nama_akun }}</h4>
                    <span class="game-badge" style="position: static; display: inline-block; margin-bottom: 0.5rem;">{{ $akun->game }}</span>
                    <div style="font-size: 0.85rem; color: var(--text-light);">
                        Level {{ $akun->level ?? '-' }} | Rank {{ $akun->rank ?? '-' }}
                    </div>
                </div>
            </div>

            <div style="border-top: 1px dashed var(--border); padding-top: 1.5rem; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--text-secondary);">Seller</span>
                    <span style="color: var(--text-primary); font-weight: bold;">{{ $akun->penjual }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--text-secondary);">Price</span>
                    <span style="color: var(--accent); font-weight: bold;"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }} Point</span>
                </div>
            </div>
            
            <div style="background: rgba(46, 204, 113, 0.1); padding: 1rem; border-radius: 8px; border: 1px solid rgba(46, 204, 113, 0.3);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-secondary); font-size: 0.9rem;">Your Balance</span>
                    <span style="color: var(--success); font-weight: bold; font-size: 1.1rem;"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format(Auth::user()->points, 0, ',', '.') }} Point</span>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; border: 1px solid var(--border);">
            <h3 style="color: var(--text-primary); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Payment Details</h3>

            @if(session('error'))
                <div style="background: var(--danger); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process', $akun->id_akun) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Payment Method</label>
                    <div style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--primary); background: rgba(88, 101, 242, 0.1); color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.2rem;"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"></span> Game Vault Points
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Delivery Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                           style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-main); color: var(--text-primary);"
                           placeholder="Where should we send the account details?">
                    <small style="color: var(--text-light); font-size: 0.8rem; display: block; margin-top: 0.5rem;">Account credentials will be sent to this email immediately after purchase.</small>
                    @error('email')
                        <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                @if(Auth::user()->points >= $akun->harga)
                    <button type="submit" class="cta-btn" style="width: 100%; border: none; font-size: 1.1rem; padding: 1rem; display: flex; justify-content: center; align-items: center; gap: 10px;">
                        Pay <img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }} Point
                    </button>
                @else
                    <a href="{{ route('topup') }}" class="cta-btn" style="width: 100%; border: none; font-size: 1.1rem; padding: 1rem; display: flex; justify-content: center; align-items: center; gap: 10px; background: var(--danger); text-decoration: none; text-align: center;">
                        Insufficient Points - Top Up Now
                    </a>
                @endif
            </form>
        </div>

    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
