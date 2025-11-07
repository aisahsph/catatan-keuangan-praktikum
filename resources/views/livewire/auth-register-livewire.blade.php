<<<<<<< HEAD
<form wire:submit.prevent="register">
    {{-- Container Card: Lebih besar, shadow tebal, dan rounded --}}
    <div class="card mx-auto p-4 shadow-lg border-0" style="max-width: 400px; border-radius: 15px; background: #ffffff;">
        <div class="card-body">
            <div>
                {{-- Header Aplikasi --}}
                <div class="text-center mb-4">
                    <img src="/logo.png" alt="Logo" style="max-height: 80px;">
                    {{-- Aesthetic Heading: Font besar dan warna aksen --}}
                    <h2 class="mt-3 mb-0 fw-bolder text-primary" style="font-size: 1.8rem; letter-spacing: 0.5px;">
                        Mendaftar untuk {{ config('app.name', 'Catatan Keuangan') }}
                    </h2>
                    <p class="text-muted mt-1 small">Buat akun baru Anda.</p>
                </div>
                
                {{-- Separator Aesthetic --}}
                <div class="hr-aesthetic mb-4" style="height: 2px; background: linear-gradient(to right, #0d6efd, #6610f2); border: none; opacity: 0.15;"></div>
                
                {{-- Nama --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Nama</label>
                    <input type="text" class="form-control form-control-lg border-2" wire:model="name" style="border-radius: 8px;">
                    @error('name')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Alamat Email --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Email</label>
                    <input type="email" class="form-control form-control-lg border-2" wire:model="email" style="border-radius: 8px;">
                    @error('email')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Kata Sandi (DENGAN IKON MATA) --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" 
                                class="form-control form-control-lg border-2" 
                                wire:model="password"
                                id="register-password-field" {{-- ID unik --}}
                                style="border-radius: 8px 0 0 8px;"> 
                        
                        <button type="button" 
                                class="btn btn-outline-secondary border-2" 
                                onclick="togglePasswordVisibility('register-password-field', 'toggle-icon-reg')"
                                style="border-left: none; border-radius: 0 8px 8px 0;">
                            <i class="fas fa-eye text-primary" id="toggle-icon-reg"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Konfirmasi Kata Sandi (DENGAN IKON MATA) --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold text-dark mb-1 small">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" 
                                class="form-control form-control-lg border-2" 
                                wire:model="password_confirmation" 
                                id="confirm-password-field" {{-- ID unik --}}
                                style="border-radius: 8px 0 0 8px;"> 
                        
                        <button type="button" 
                                class="btn btn-outline-secondary border-2" 
                                onclick="togglePasswordVisibility('confirm-password-field', 'toggle-icon-conf')"
                                style="border-left: none; border-radius: 0 8px 8px 0;">
                            <i class="fas fa-eye text-primary" id="toggle-icon-conf"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kirim (Aesthetic Gradient Button) --}}
                <div class="form-group mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm btn-gradient"
                            style="border-radius: 8px; background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); border: none; transition: transform 0.2s;">
                        <span class="fw-bold">DAFTAR</span>
                    </button>
                </div>

                <div class="hr-aesthetic mt-4 mb-3" style="height: 1px; background: #e9ecef; border: none; opacity: 0.8;"></div>

                <p class="text-center small text-muted">
                    Sudah memiliki akun? 
                    <a href="{{ route('auth.login') }}" class="text-decoration-none fw-semibold text-primary">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</form>

{{-- SCRIPT JAVASCRIPT UNTUK TOGGLE PASSWORD (Diperbarui untuk menangani multi-field) --}}
<script>
    // Fungsi ini menangani toggle visibility untuk Kata Sandi dan Konfirmasi Kata Sandi
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
=======
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
    <form wire:submit.prevent="register" class="w-100" style="max-width: 420px;">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4 p-md-5">
                <!-- Logo & Title Section -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <img src="/logo.png" alt="Logo" style="max-width: 80px; height: auto;">
                    </div>
                    <h2 class="h4 fw-bold mb-2">Mendaftar untuk {{ config('app.name', 'Catatan Keuangan') }}</h2>
                    <p class="text-muted small mb-0">Buat akun baru untuk memulai</p>
                </div>

                <hr class="my-4">

                <!-- Name Field -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input 
                        type="text" 
                        class="form-control form-control-lg" 
                        wire:model="name"
                        placeholder="Nama lengkap"
                    >
                    @error('name')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input 
                        type="email" 
                        class="form-control form-control-lg" 
                        wire:model="email"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Kata Sandi</label>
                    <input 
                        type="password" 
                        class="form-control form-control-lg" 
                        wire:model="password"
                        placeholder="Buat kata sandi"
                    >
                    @error('password')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Kirim
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-muted mb-0">
                        Sudah memiliki akun? 
                        <a href="{{ route('auth.login') }}" class="text-decoration-none fw-semibold">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
>>>>>>> 865836dd6a57f0303f45244c454b9b18afca357a
