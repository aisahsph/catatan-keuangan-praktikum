<form wire:submit.prevent="login">
    {{-- Container Card: Lebih besar, shadow tebal, dan rounded --}}
    <div class="card mx-auto p-4 shadow-lg border-0" style="max-width: 400px; border-radius: 15px; background: #ffffff;">
        <div class="card-body">
            <div>
                {{-- Header Aplikasi --}}
                <div class="text-center mb-4">
                    <img src="/logo.png" alt="Logo" style="max-height: 80px;">
                    {{-- Aesthetic Heading: Font besar dan warna aksen --}}
                    <h2 class="mt-3 mb-0 fw-bolder text-primary" style="font-size: 1.8rem; letter-spacing: 0.5px;">
                        Masuk ke {{ config('app.name', 'Catatan Keuangan') }}
                    </h2>
                    <p class="text-muted mt-1 small">Kelola keuangan Anda dengan mudah.</p>
                </div>
                
                {{-- Separator Aesthetic --}}
                <div class="hr-aesthetic mb-4" style="height: 2px; background: linear-gradient(to right, #0d6efd, #6610f2); border: none; opacity: 0.15;"></div>
                
                {{-- Alamat Email --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Email</label>
                    <input type="email" class="form-control form-control-lg border-2" wire:model="email" style="border-radius: 8px;">
                    @error('email')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Kata Sandi (Aesthetic dengan Icon Toggle) --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" 
                                class="form-control form-control-lg border-2" 
                                wire:model="password" 
                                id="password-field"
                                style="border-radius: 8px 0 0 8px;"> 
                        
                        <button type="button" 
                                class="btn btn-outline-secondary border-2" 
                                onclick="togglePasswordVisibility('password-field', 'toggle-icon-login')"
                                style="border-left: none; border-radius: 0 8px 8px 0;">
                            <i class="fas fa-eye text-primary" id="toggle-icon-login"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kirim (Aesthetic Gradient Button) --}}
                <div class="form-group mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm btn-gradient"
                            style="border-radius: 8px; background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); border: none; transition: transform 0.2s;">
                        <span class="fw-bold">MASUK</span>
                    </button>
                </div>

                <div class="hr-aesthetic mt-4 mb-3" style="height: 1px; background: #e9ecef; border: none; opacity: 0.8;"></div>

                <p class="text-center small text-muted">
                    Belum memiliki akun? 
                    <a href="{{ route('auth.register') }}" class="text-decoration-none fw-semibold text-primary">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</form>

{{-- SCRIPT JAVASCRIPT UNTUK TOGGLE PASSWORD --}}
<script>
    function togglePasswordVisibility(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>