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
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Price (Points) <img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> <span style="font-size: 0.8em; font-weight: normal; color: var(--text-light); margin-left: 5px;">(1 Point = Rp. 1000)</span></label>
                    <input type="number" name="harga" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('harga', $akun->harga) }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">WhatsApp Contact Number</label>
                    <input type="text" name="kontak" required placeholder="Example: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('kontak', $akun->kontak) }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Proof Photos <span style="font-size:0.8em; color:var(--text-light); font-weight:normal;">(Kosongkan untuk mempertahankan foto saat ini)</span></label>

                    @if($akun->foto && count($akun->foto) > 0)
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                            @foreach($akun->foto as $i => $f)
                                <div style="position:relative; width:80px; height:80px;">
                                    <img src="{{ asset('uploads/' . $f) }}" alt="Photo {{ $i+1 }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:2px solid var(--border);">
                                    <span style="position:absolute; top:4px; left:4px; background:var(--accent); color:white; font-size:0.7rem; font-weight:bold; padding:2px 6px; border-radius:4px;">{{ $i+1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file" name="foto[]" id="fotoInputEdit" accept="image/*" multiple
                           style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;"
                           onchange="previewFotosEdit(this)">
                    <small style="color:var(--text-light); font-size:0.8rem;">Max 5 foto, masing-masing maks 5MB</small>
                    <div id="sizeErrorEdit" style="display:none; color: var(--danger, #ed4245); font-size:0.85rem; margin-top:0.4rem;">
                        ⚠ Salah satu file melebihi batas 5MB. Mohon pilih ulang.
                    </div>
                    <div id="fotoPreviewEdit" style="display:flex; flex-wrap:wrap; gap:8px; margin-top:10px;"></div>
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

@push('scripts')
<script>
function previewFotosEdit(input) {
    const preview = document.getElementById('fotoPreviewEdit');
    const sizeError = document.getElementById('sizeErrorEdit');
    preview.innerHTML = '';
    sizeError.style.display = 'none';

    const maxSize = 5 * 1024 * 1024;
    const maxFiles = 5;
    let hasError = false;

    Array.from(input.files).slice(0, maxFiles).forEach((file, index) => {
        if (file.size > maxSize) { hasError = true; return; }

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'position:relative; width:80px; height:80px;';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px; height:80px; object-fit:cover; border-radius:8px; border:2px solid var(--accent);';

            const badge = document.createElement('span');
            badge.textContent = 'Baru ' + (index + 1);
            badge.style.cssText = 'position:absolute; top:4px; left:4px; background:var(--success,#57f287); color:#000; font-size:0.65rem; font-weight:bold; padding:2px 5px; border-radius:4px;';

            wrapper.appendChild(img);
            wrapper.appendChild(badge);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    if (hasError) {
        sizeError.style.display = 'block';
        input.value = '';
        preview.innerHTML = '';
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    const input = document.getElementById('fotoInputEdit');
    const maxSize = 5 * 1024 * 1024;
    for (let file of input.files) {
        if (file.size > maxSize) {
            e.preventDefault();
            document.getElementById('sizeErrorEdit').style.display = 'block';
            return;
        }
    }
});
</script>
@endpush
