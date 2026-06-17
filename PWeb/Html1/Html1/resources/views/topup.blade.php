@extends('layouts.app')

@section('title', 'Topup Points - Game Vault')

@section('content')
    <div style="padding: 2rem;">
        <div style="margin: 0 auto; max-width: 600px; background: var(--bg-card); padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow); text-align: center;">
            <h2 style="color: var(--text-primary); margin-bottom: 1rem;">Isi Ulang Diamond Point 💎</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Tambahkan point untuk membeli akun idamanmu!</p>
            
            @if(session('success'))
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-bottom: 2rem; background: var(--bg-main); padding: 1.5rem; border-radius: 8px;">
                <span style="font-size: 1.2rem; color: var(--text-secondary);">Point Anda Saat Ini:</span>
                <span style="font-size: 2rem; font-weight: bold; color: var(--accent);">💎 {{ number_format(Auth::user()->points, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('topup.process') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 1.5rem; text-align: left;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-primary);">Jumlah Point yang Ingin Dibeli</label>
                    <select name="amount" required style="width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-primary); font-size: 1.1rem;">
                        <option value="1000">💎 1.000 Point (Rp 10.000)</option>
                        <option value="5000">💎 5.000 Point (Rp 50.000)</option>
                        <option value="10000">💎 10.000 Point (Rp 100.000)</option>
                        <option value="50000">💎 50.000 Point (Rp 500.000)</option>
                        <option value="100000">💎 100.000 Point (Rp 1.000.000)</option>
                    </select>
                </div>
                
                <button type="submit" class="cta-btn" style="width: 100%; padding: 1rem; font-size: 1.2rem; margin-top: 1rem;">Lanjutkan Pembayaran (Topup)</button>
            </form>
        </div>
    </div>
@endsection
