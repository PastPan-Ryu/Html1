@extends('layouts.app')

@section('title', 'Dashboard - Game Vault')

@section('content')

@if(session('success'))
    <div style="background: var(--success); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
        {{ session('success') }}
    </div>
@endif

<!-- Section 1: Akun Terbaru (Matches "Weekly quests" style) -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
    <div>
        <div class="section-subtitle">DON'T MISS THEM</div>
        <h2 class="section-title" style="margin-bottom:0;">Latest Accounts</h2>
    </div>
    <div style="display: flex; gap: 10px;">
        <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 15px; border-radius: 5px; cursor: pointer;">All Games</button>
        <div style="display:flex; gap:5px;">
            <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 10px; border-radius: 5px; cursor: pointer;">&lt;</button>
            <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 10px; border-radius: 5px; cursor: pointer;">&gt;</button>
        </div>
    </div>
</div>

<div class="cards-grid">
    @forelse($akuns->take(4) as $akun)
        <div class="card-v2">
            <div class="card-image-wrapper">
                <span class="game-badge">{{ $akun->game }}</span>
                <img src="{{ ($akun->foto && count($akun->foto) > 0) ? asset('uploads/'.$akun->foto[0]) : 'https://ui-avatars.com/api/?name='.urlencode($akun->nama_akun).'&background=3282B8&color=fff&size=400' }}" alt="Account Image" class="card-image">
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ $akun->nama_akun }}</h3>
                <div class="card-desc">
                    Level {{ $akun->level ?? '-' }} | Rank {{ $akun->rank ?? '-' }}<br>
                    {{ Str::limit($akun->deskripsi, 50) }}
                </div>
                <div class="price-text"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }}</div>
                <a href="{{ route('checkout', $akun->id_akun) }}" class="buy-btn-circle" style="{{ $akun->status == 'Terjual' ? 'background:#555;color:#888;pointer-events:none;' : '' }}">
                    {!! $akun->status == 'Terjual' ? '&#10005;' : '&#10095;' !!}
                </a>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; color: var(--text-secondary); text-align: center; padding: 2rem;">
            No recent accounts available.
        </div>
    @endforelse
</div>

<!-- Section 2: Game Populer (Matches "Popular games" style) -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem; margin-top: 3rem;">
    <div>
        <div class="section-subtitle">TO THE TOP</div>
        <h2 class="section-title" style="margin-bottom:0;">All Accounts</h2>
    </div>
    <div style="display: flex; gap: 10px;">
        <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 15px; border-radius: 5px; cursor: pointer;">All Games</button>
        <div style="display:flex; gap:5px;">
            <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 10px; border-radius: 5px; cursor: pointer;">&lt;</button>
            <button style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border); padding: 5px 10px; border-radius: 5px; cursor: pointer;">&gt;</button>
        </div>
    </div>
</div>

<div class="cards-grid">
    @forelse($akuns as $akun)
        <div class="card" style="display: flex; flex-direction: row; height: 120px;">
            <div class="card-image-wrapper" style="width: 120px; height: 100%;">
                <span class="game-badge" style="top: 5px; left: 5px; font-size:0.65rem;">{{ $akun->game }}</span>
                <img src="{{ ($akun->foto && count($akun->foto) > 0) ? asset('uploads/'.$akun->foto[0]) : 'https://ui-avatars.com/api/?name='.urlencode($akun->nama_akun).'&background=3282B8&color=fff&size=400' }}" alt="Account Image" class="card-image" style="border-radius:0; height:100%; margin-bottom:0;">
            </div>
            <div class="card-body" style="flex: 1; padding: 0.8rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 1rem;">{{ $akun->nama_akun }}</h3>
                    <div class="card-desc" style="font-size:0.75rem; margin-bottom:0; height:auto; color: var(--text-light);">
                        Level {{ $akun->level ?? '-' }} | Rank {{ $akun->rank ?? '-' }}
                    </div>
                </div>
                <div class="card-footer" style="padding-top: 0.5rem; border-top: none;">
                    <div class="card-stats" style="font-size: 0.85rem; color: var(--accent); font-weight: bold;">
                        <span><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }} Point</span>
                    </div>
                    <a href="{{ route('checkout', $akun->id_akun) }}" class="cta-btn" style="padding: 3px 10px; font-size: 0.75rem; text-decoration: none; text-align: center; {{ $akun->status == 'Terjual' ? 'background:#40444b;color:#888;pointer-events:none;' : '' }}">
                        {{ $akun->status == 'Terjual' ? 'Sold' : 'Buy' }}
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; color: var(--text-secondary); text-align: center; padding: 2rem;">
            No accounts available.
        </div>
    @endforelse
</div>

@endsection
