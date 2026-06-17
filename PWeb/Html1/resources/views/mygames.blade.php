@extends('layouts.app')

@section('title', 'My Games - Game Vault')

@section('content')
    <div style="padding: 2rem; min-height: 80vh;">
        <div class="container" style="padding: 0;">
            <h3 style="margin-bottom: 1.5rem; color: var(--text-primary);">Accounts You Have Bought</h3>
            
            <div class="cards-grid" id="myGamesGrid">
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
                            <div class="card-footer" style="padding-top: 0.5rem; border-top: none; justify-content: space-between; align-items: center;">
                                <div class="card-stats" style="font-size: 0.85rem; color: var(--accent); font-weight: bold;">
                                    <span><img src="{{ asset('images/diamond.png') }}" class="custom-diamond"> {{ number_format($akun->harga, 0, ',', '.') }} Point</span>
                                </div>
                                <button class="cta-btn btn-small view-credentials-btn" 
                                        data-game="{{ $akun->game }}"
                                        data-nama="{{ $akun->nama_akun }}"
                                        data-email="{{ $akun->login_email ?? 'Not provided' }}"
                                        data-password="{{ $akun->login_password ?? 'Not provided' }}"
                                        style="padding: 4px 10px; font-size: 0.75rem;">
                                    View Credentials
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-light); padding: 2rem; background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border);">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--text-secondary);"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <h4 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 1.2rem;">No purchases yet</h4>
                        <p style="margin-bottom: 1.5rem;">You haven't bought any accounts. Explore the marketplace to find your dream account!</p>
                        <a href="{{ route('home') }}" class="cta-btn" style="text-decoration: none; display: inline-block;">Explore Games</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Credentials Modal -->
    <div id="credentialsModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); align-items: center; justify-content: center;">
        <div style="background: var(--bg-card); padding: 2rem; border-radius: 12px; width: 90%; max-width: 400px; position: relative; border: 1px solid var(--border);">
            <span id="closeCredentialsModal" style="position: absolute; right: 20px; top: 15px; font-size: 1.5rem; cursor: pointer; color: var(--text-light);">&times;</span>
            <h3 style="margin-bottom: 1.5rem; color: var(--accent); border-bottom: 1px solid var(--border); padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Account Credentials
            </h3>
            
            <div style="margin-bottom: 1rem;">
                <strong style="color: var(--text-secondary); font-size: 0.85rem;">Game & Account Name</strong>
                <div id="modalCredName" style="color: var(--text-primary); font-size: 1.1rem; margin-top: 5px; margin-bottom: 15px;"></div>
                
                <strong style="color: var(--text-secondary); font-size: 0.85rem;">Login Email / Username</strong>
                <div id="modalCredEmail" style="background: var(--bg-main); padding: 10px; border-radius: 6px; color: var(--text-primary); font-family: monospace; font-size: 1rem; margin-top: 5px; margin-bottom: 15px; border: 1px solid var(--border); word-break: break-all;"></div>
                
                <strong style="color: var(--text-secondary); font-size: 0.85rem;">Login Password</strong>
                <div id="modalCredPassword" style="background: var(--bg-main); padding: 10px; border-radius: 6px; color: var(--text-primary); font-family: monospace; font-size: 1rem; margin-top: 5px; border: 1px solid var(--border); word-break: break-all;"></div>
            </div>
            
            <p style="font-size: 0.8rem; color: var(--danger); margin-top: 1.5rem; text-align: center;">
                Please secure this account by changing the password immediately after logging in.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('credentialsModal');
            const closeBtn = document.getElementById('closeCredentialsModal');
            
            document.querySelectorAll('.view-credentials-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('modalCredName').textContent = this.getAttribute('data-game') + ' - ' + this.getAttribute('data-nama');
                    document.getElementById('modalCredEmail').textContent = this.getAttribute('data-email');
                    document.getElementById('modalCredPassword').textContent = this.getAttribute('data-password');
                    modal.style.display = 'flex';
                });
            });

            if(closeBtn) {
                closeBtn.addEventListener('click', () => modal.style.display = 'none');
            }

            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });
        });
    </script>
@endsection
