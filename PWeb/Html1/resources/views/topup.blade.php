@extends('layouts.app')

@section('title', 'Topup Points - Game Vault')

@section('content')
    <style>
        .topup-option {
            display: none;
        }
        .topup-card {
            background: var(--bg-main);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .topup-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: transparent;
            transition: background 0.3s;
        }
        .topup-card:hover {
            border-color: var(--accent);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .topup-option:checked + .topup-card {
            background: rgba(88, 101, 242, 0.05); /* very light accent */
            border-color: var(--accent);
            box-shadow: 0 8px 25px rgba(88, 101, 242, 0.25);
        }
        .topup-option:checked + .topup-card::before {
            background: var(--accent);
        }
        .topup-card .diamond-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
            transition: transform 0.3s;
        }
        .topup-option:checked + .topup-card .diamond-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .topup-card .point-amount {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.2rem;
        }
        .topup-card .price {
            font-size: 0.95rem;
            color: var(--success);
            font-weight: 600;
        }
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .current-balance {
            background: linear-gradient(135deg, var(--bg-main) 0%, rgba(88, 101, 242, 0.1) 100%);
            border: 1px solid rgba(88, 101, 242, 0.2);
        }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background: var(--bg-card);
            padding: 2.5rem;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            transform: translateY(20px);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            text-align: left;
        }
        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }
        .payment-method-card {
            background: var(--bg-main);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-method-card:hover {
            border-color: var(--accent);
            background: rgba(114, 137, 218, 0.05);
        }
        .payment-option:checked + .payment-method-card {
            border-color: var(--accent);
            background: rgba(114, 137, 218, 0.1);
        }
        .payment-details h4 {
            margin: 0 0 0.2rem 0;
            color: var(--text-primary);
        }
        .payment-details p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
    </style>

    <div style="padding: 2rem;">
        <div style="margin: 0 auto; max-width: 800px; background: var(--bg-card); padding: 3rem; border-radius: 20px; box-shadow: var(--shadow); text-align: center;">
            <h2 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 2rem;">Topup Diamond Vault <img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-lg"></h2>
            <p style="color: var(--text-secondary); margin-bottom: 2.5rem; font-size: 1.1rem;">Pilih paket point untuk membeli akun game idamanmu!</p>
            
            @if(session('success'))
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;">
                    {!! session('success') !!}
                </div>
            @endif

            @if(session('error'))
                <div style="background: var(--danger, #ed4245); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: var(--danger, #ed4245); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 3rem; flex-wrap: wrap;">
                <div style="background: rgba(88, 101, 242, 0.2); border: 1px solid var(--accent); color: var(--text-primary); padding: 0.8rem 2rem; border-radius: 50px; font-weight: bold; cursor: default;">
                    Topup Saldo
                </div>
                <button type="button" onclick="openWithdrawModal()" style="background: transparent; border: 1px solid var(--border); color: var(--text-secondary); padding: 0.8rem 2rem; border-radius: 50px; font-weight: bold; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--text-primary)'; this.style.color='var(--text-primary)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-secondary)';">
                    Tarik Saldo
                </button>
            </div>

            <form action="{{ route('topup.process') }}" method="POST">
                @csrf
                <div style="text-align: left;">
                    <label style="display:block; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-primary); font-size: 1.2rem;">Pilih Nominal Topup</label>
                    
                    <div class="packages-grid">
                        <label>
                            <input type="radio" name="amount" value="10" class="topup-option" required>
                            <div class="topup-card">
                                <div class="diamond-icon"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-xl"></div>
                                <div class="point-amount">10 Point</div>
                                <div class="price">Rp 10.000</div>
                            </div>
                        </label>
                        
                        <label>
                            <input type="radio" name="amount" value="50" class="topup-option">
                            <div class="topup-card">
                                <div class="diamond-icon"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-xl"></div>
                                <div class="point-amount">50 Point</div>
                                <div class="price">Rp 50.000</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="amount" value="100" class="topup-option">
                            <div class="topup-card">
                                <div class="diamond-icon"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-xl"></div>
                                <div class="point-amount">100 Point</div>
                                <div class="price">Rp 100.000</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="amount" value="500" class="topup-option">
                            <div class="topup-card">
                                <div class="diamond-icon"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-xl"></div>
                                <div class="point-amount">500 Point</div>
                                <div class="price">Rp 500.000</div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="amount" value="1000" class="topup-option">
                            <div class="topup-card">
                                <div class="diamond-icon"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-xl"></div>
                                <div class="point-amount">1.000 Point</div>
                                <div class="price">Rp 1.000.000</div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <button type="button" class="cta-btn" onclick="openPaymentModal()" style="width: 100%; padding: 1.2rem; font-size: 1.2rem; margin-top: 1rem; border-radius: 12px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">
                    Lanjutkan Pembayaran
                </button>

                <!-- Payment Modal -->
                <div class="modal-overlay" id="paymentModal">
                    <div class="modal-content">
                        <h3 style="color: var(--text-primary); margin-bottom: 1.5rem; text-align: center; font-size: 1.5rem;">Pilih Metode Pembayaran</h3>
                        
                        <label>
                            <input type="radio" name="payment_method" value="bank" class="topup-option payment-option" required>
                            <div class="payment-method-card">
                                <div class="payment-details">
                                    <h4>Transfer Bank</h4>
                                    <p>BCA, Mandiri, BNI, BRI</p>
                                </div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="payment_method" value="ewallet" class="topup-option payment-option">
                            <div class="payment-method-card">
                                <div class="payment-details">
                                    <h4>E-Wallet</h4>
                                    <p>GoPay, OVO, DANA, ShopeePay</p>
                                </div>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="payment_method" value="qris" class="topup-option payment-option">
                            <div class="payment-method-card">
                                <div class="payment-details">
                                    <h4>QRIS</h4>
                                    <p>Scan barcode dengan aplikasi apapun</p>
                                </div>
                            </div>
                        </label>

                        <div class="modal-actions">
                            <button type="button" onclick="closePaymentModal()" style="flex: 1; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); background: transparent; color: var(--text-primary); font-weight: bold; cursor: pointer;">Batal</button>
                            <button type="button" class="cta-btn" onclick="processPaymentMethod()" style="flex: 2; padding: 1rem; border-radius: 12px; border: none; font-weight: bold;">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Payment Detail Modal (Step 2) -->
                <div class="modal-overlay" id="paymentDetailModal">
                    <div class="modal-content" style="text-align: center;">
                        <h3 id="detailModalTitle" style="color: var(--text-primary); margin-bottom: 1.5rem; font-size: 1.5rem;">Selesaikan Pembayaran</h3>
                        
                        <!-- Dynamic Content Containers -->
                        <div id="bankDetails" style="display: none; margin-bottom: 2rem;">
                            <p style="color: var(--text-secondary); margin-bottom: 1rem;">Nomor Virtual Account Anda:</p>
                            <div style="background: var(--bg-main); padding: 1rem; border-radius: 8px; border: 1px dashed var(--accent); font-size: 1.5rem; font-weight: bold; letter-spacing: 2px; color: var(--accent);" id="vaNumber"></div>
                            <p style="color: var(--text-light); font-size: 0.85rem; margin-top: 1rem;">Silakan transfer sesuai nominal ke nomor di atas.</p>
                        </div>

                        <div id="ewalletDetails" style="display: none; margin-bottom: 2rem; text-align: left;">
                            <label style="display: block; color: var(--text-secondary); margin-bottom: 0.5rem;">Nomor HP yang terhubung ke E-Wallet (Contoh: 08123456789)</label>
                            <input type="number" name="ewallet_number" id="ewalletInput" placeholder="08..." style="width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-primary); font-size: 1.1rem;">
                        </div>

                        <div id="qrisDetails" style="display: none; margin-bottom: 2rem;">
                            <p style="color: var(--text-secondary); margin-bottom: 1rem;">Scan QRIS ini dengan aplikasi E-Wallet / m-Banking Anda:</p>
                            <div style="background: white; padding: 1rem; display: inline-block; border-radius: 12px; margin: 0 auto;">
                                <img id="qrisImage" src="" alt="QRIS" style="width: 200px; height: 200px;">
                            </div>
                        </div>

                        <div class="modal-actions">
                            <button type="button" onclick="closeDetailModal()" style="flex: 1; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); background: transparent; color: var(--text-primary); font-weight: bold; cursor: pointer;">Kembali</button>
                            <button type="submit" class="cta-btn" style="flex: 2; padding: 1rem; border-radius: 12px; border: none; font-weight: bold;">Selesaikan Transaksi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Withdraw Modal -->
    <div class="modal-overlay" id="withdrawModal">
        <div class="modal-content" style="text-align: left;">
            <h3 style="color: var(--text-primary); margin-bottom: 1.5rem; text-align: center; font-size: 1.5rem;">Tarik Saldo</h3>
            
            <form action="{{ route('topup.withdraw') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem; text-align: center; background: rgba(88, 101, 242, 0.1); padding: 1rem; border-radius: 12px; border: 1px solid var(--accent);">
                    <span style="font-size: 1rem; color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Saldo Tersedia</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--accent);"><img src="{{ asset('images/diamond.png') }}" class="custom-diamond diamond-lg"> {{ number_format(Auth::user()->points, 0, ',', '.') }} Point</span>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-secondary); margin-bottom: 0.5rem;">Nominal Penarikan (Point)</label>
                    <input type="number" name="withdraw_amount" required min="100" max="{{ Auth::user()->points }}" placeholder="Minimal 100 Point" style="width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-primary); font-size: 1.1rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-secondary); margin-bottom: 0.5rem;">Metode Pencairan</label>
                    <select name="withdraw_method" required style="width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-primary); font-size: 1.1rem;">
                        <option value="" disabled selected>Pilih Metode...</option>
                        <option value="Transfer BCA">Transfer BCA</option>
                        <option value="Transfer Mandiri">Transfer Mandiri</option>
                        <option value="DANA">DANA</option>
                        <option value="GoPay">GoPay</option>
                        <option value="OVO">OVO</option>
                    </select>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; color: var(--text-secondary); margin-bottom: 0.5rem;">Nomor Rekening / E-Wallet</label>
                    <input type="text" name="withdraw_account" required placeholder="Contoh: 08123456789" style="width: 100%; padding: 1rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-primary); font-size: 1.1rem;">
                </div>

                <div class="modal-actions">
                    <button type="button" onclick="closeWithdrawModal()" style="flex: 1; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); background: transparent; color: var(--text-primary); font-weight: bold; cursor: pointer;">Batal</button>
                    <button type="submit" class="cta-btn" style="flex: 2; padding: 1rem; border-radius: 12px; border: none; font-weight: bold;">Tarik Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPaymentModal() {
            // Check if amount is selected
            const amountSelected = document.querySelector('input[name="amount"]:checked');
            if (!amountSelected) {
                alert('Silakan pilih nominal topup terlebih dahulu!');
                return;
            }
            document.getElementById('paymentModal').classList.add('active');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.remove('active');
        }

        function processPaymentMethod() {
            const methodSelected = document.querySelector('input[name="payment_method"]:checked');
            if (!methodSelected) {
                alert('Silakan pilih metode pembayaran terlebih dahulu!');
                return;
            }

            const method = methodSelected.value;
            
            // Hide step 1 modal
            document.getElementById('paymentModal').classList.remove('active');

            // Reset step 2 views
            document.getElementById('bankDetails').style.display = 'none';
            document.getElementById('ewalletDetails').style.display = 'none';
            document.getElementById('qrisDetails').style.display = 'none';
            document.getElementById('ewalletInput').required = false;

            // Setup step 2 views based on choice
            if (method === 'bank') {
                document.getElementById('detailModalTitle').innerText = 'Transfer Bank';
                document.getElementById('bankDetails').style.display = 'block';
                // Generate random 12-16 digit VA number
                const va = Math.floor(Math.random() * 900000000000) + 100000000000;
                document.getElementById('vaNumber').innerText = 'VA-' + va;
            } else if (method === 'ewallet') {
                document.getElementById('detailModalTitle').innerText = 'Pembayaran E-Wallet';
                document.getElementById('ewalletDetails').style.display = 'block';
                document.getElementById('ewalletInput').required = true;
            } else if (method === 'qris') {
                document.getElementById('detailModalTitle').innerText = 'Pembayaran QRIS';
                document.getElementById('qrisDetails').style.display = 'block';
                // Generate a random string to change the QR code visually
                const randomString = Math.random().toString(36).substring(7);
                document.getElementById('qrisImage').src = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=GameVaultTopup_' + randomString;
            }

            // Show step 2 modal
            document.getElementById('paymentDetailModal').classList.add('active');
        }

        function closeDetailModal() {
            document.getElementById('paymentDetailModal').classList.remove('active');
            document.getElementById('paymentModal').classList.add('active');
        }

        // Close modals when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) closePaymentModal();
        });
        document.getElementById('paymentDetailModal').addEventListener('click', function(e) {
            if (e.target === this) closeDetailModal();
        });

        function openWithdrawModal() {
            document.getElementById('withdrawModal').classList.add('active');
        }

        function closeWithdrawModal() {
            document.getElementById('withdrawModal').classList.remove('active');
        }

        document.getElementById('withdrawModal').addEventListener('click', function(e) {
            if (e.target === this) closeWithdrawModal();
        });
    </script>
@endsection
