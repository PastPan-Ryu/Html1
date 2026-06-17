@extends('layouts.app')

@section('title', 'Post Account - Game Vault')

@section('content')
    <div style="padding: 2rem; min-height: 80vh;">
        <div class="container" style="padding: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: var(--text-primary);">Your Account Posts</h3>
                <a href="{{ route('jualakun') }}" class="cta-btn" style="text-decoration: none; padding: 6px 15px; font-size: 0.9rem;">Sell Account</a>
            </div>
            
            @if(session('success'))
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="cards-grid" id="myCardsGrid">
                @forelse($akuns as $akun)
                    <div class="card-v2">
                        <div class="card-image-wrapper">
                            <span class="game-badge" style="{{ $akun->status == 'Terjual' ? 'background: #95a5a6;' : '' }}">{{ $akun->game }}</span>
                            <img src="{{ ($akun->foto && count($akun->foto) > 0) ? asset('uploads/'.$akun->foto[0]) : 'https://ui-avatars.com/api/?name='.urlencode($akun->nama_akun).'&background=3282B8&color=fff&size=400' }}" alt="Account Image" class="card-image">
                        </div>
                        <div class="card-body" style="padding-bottom: 5rem;">
                            <h3 class="card-title">{{ $akun->nama_akun }}</h3>
                            <div class="card-desc">
                                Level {{ $akun->level ?? '-' }} | Rank {{ $akun->rank ?? '-' }}
                            </div>
                            <div class="price-text"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }} Point</div>
                            
                            <div style="position: absolute; bottom: 1.5rem; left: 1.5rem; right: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.9rem; font-weight: bold; color: {{ $akun->status == 'Terjual' ? 'var(--danger)' : 'var(--success)' }};">{{ $akun->status == 'Terjual' ? 'Sold' : 'Available' }}</span>
                                
                                @if($akun->status == 'Tersedia')
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('jualakun.edit', $akun->id_akun) }}" class="cta-btn btn-small" style="background: var(--primary); text-decoration: none; padding: 4px 10px; border-radius: 8px; font-size: 0.8rem;">Edit</a>
                                        <form action="{{ route('jualakun.terjual', $akun->id_akun) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="cta-btn btn-small" style="background: var(--accent); padding: 4px 10px; border-radius: 8px; font-size: 0.8rem; border: none; cursor: pointer; color: white; font-weight: bold;">Sold</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-light); padding: 2rem;">
                        You haven't posted any accounts yet. <a href="{{ route('jualakun') }}" style="color: var(--primary);">Sell Account Now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
