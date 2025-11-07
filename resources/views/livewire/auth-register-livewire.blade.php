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