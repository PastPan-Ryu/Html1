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
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Price (Points) <img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> <span style="font-size: 0.8em; font-weight: normal; color: var(--text-light); margin-left: 5px;">(1 Point = Rp. 1000)</span></label>
                    <input type="number" name="harga" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('harga') }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">WhatsApp Contact Number</label>
                    <input type="text" name="kontak" required placeholder="Example: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;" value="{{ old('kontak') }}">
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label style="display:block; font-weight: 500; margin-bottom: 0.5rem;">Account Proof Photos <span style="font-size:0.8em; color:var(--text-light); font-weight:normal;">(Max 5 foto, masing-masing maks 5MB)</span></label>
                    <input type="file" name="foto[]" id="fotoInput" accept="image/*" multiple
                           style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px;"
                           onchange="previewFotos(this)">
                    <div id="sizeError" style="display:none; color: var(--danger, #ed4245); font-size:0.85rem; margin-top:0.4rem;">
                        ⚠ Salah satu file melebihi batas 5MB. Mohon pilih ulang.
                    </div>
                    <div id="fotoPreview" style="display:flex; flex-wrap:wrap; gap:8px; margin-top:10px;"></div>
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
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" name="login_password" required placeholder="Password to login to the game" style="width: 100%; padding: 0.8rem; padding-right: 2.5rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main);">
                            <button type="button" onclick="const i=this.previousElementSibling;const h=i.type==='password';i.type=h?'text':'password';this.querySelector('svg').style.display=h?'none':'block';this.querySelector('svg.off').style.display=h?'block':'none';" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: var(--text-secondary); padding: 0; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="off" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; font-size: 1.1rem;">Post Account</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function previewFotos(input) {
    const preview = document.getElementById('fotoPreview');
    const sizeError = document.getElementById('sizeError');
    preview.innerHTML = '';
    sizeError.style.display = 'none';

    const maxSize = 5 * 1024 * 1024; // 5MB
    const maxFiles = 5;
    let hasError = false;

    const files = Array.from(input.files).slice(0, maxFiles);

    files.forEach((file, index) => {
        if (file.size > maxSize) {
            hasError = true;
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'position:relative; width:80px; height:80px;';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px; height:80px; object-fit:cover; border-radius:8px; border:2px solid var(--accent);';

            const badge = document.createElement('span');
            badge.textContent = index + 1;
            badge.style.cssText = 'position:absolute; top:4px; left:4px; background:var(--accent); color:white; font-size:0.7rem; font-weight:bold; padding:2px 6px; border-radius:4px;';

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

// Prevent form submit if there's a size error
document.querySelector('form').addEventListener('submit', function(e) {
    const input = document.getElementById('fotoInput');
    const maxSize = 5 * 1024 * 1024;
    for (let file of input.files) {
        if (file.size > maxSize) {
            e.preventDefault();
            document.getElementById('sizeError').style.display = 'block';
            return;
        }
    }
});
</script>
@endpush
