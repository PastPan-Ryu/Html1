@extends('layouts.app')

@section('title', 'Edit Account - Game Vault')

@section('content')
    <div style="padding: 2rem;">
        <div style="margin: 0 auto; max-width: 700px; background: var(--bg-card); padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                <h2 style="color: var(--text-primary); margin: 0;">Edit Account Post</h2>
                <a href="{{ route('profile') }}" style="color: var(--accent); text-decoration: none;">&larr; Cancel</a>
            </div>
            
            @if ($errors->any())
                <div style="background: #e74c3c; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jualakun.update', $akun->id_akun) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Name / In-Game Name</label>
                    <input type="text" name="nama_akun" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('nama_akun', $akun->nama_akun) }}">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Select Game</label>
                    <select name="game" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">
                        <option value="Mobile Legends" {{ old('game', $akun->game) == 'Mobile Legends' ? 'selected' : '' }}>Mobile Legends</option>
                        <option value="Free Fire" {{ old('game', $akun->game) == 'Free Fire' ? 'selected' : '' }}>Free Fire</option>
                        <option value="PUBG Mobile" {{ old('game', $akun->game) == 'PUBG Mobile' ? 'selected' : '' }}>PUBG Mobile</option>
                        <option value="Valorant" {{ old('game', $akun->game) == 'Valorant' ? 'selected' : '' }}>Valorant</option>
                        <option value="Lainnya" {{ old('game', $akun->game) == 'Lainnya' ? 'selected' : '' }}>Others...</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.2rem;">
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Level (Optional)</label>
                        <input type="number" name="level" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('level', $akun->level) }}">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Rank (Optional)</label>
                        <input type="text" name="rank" placeholder="Example: Mythic" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('rank', $akun->rank) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Price (Points) 💎 <span style="font-size: 0.8em; font-weight: normal; color: var(--text-light); margin-left: 5px;">(1 Point = Rp. 1000)</span></label>
                    <input type="number" name="harga" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('harga', $akun->harga) }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">WhatsApp Contact Number</label>
                    <input type="text" name="kontak" required placeholder="Example: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('kontak', $akun->kontak) }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Proof Photo (Leave empty to keep current)</label>
                    @if($akun->foto)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('uploads/' . $akun->foto) }}" alt="Current Photo" style="max-height: 100px; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Short Description</label>
                    <textarea name="deskripsi" rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;">{{ old('deskripsi', $akun->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; font-size: 1.1rem; background: var(--success);">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
