<div class="mt-4">
    <div class="card border-0 shadow-lg rounded-4 aesthetic-wrapper">
        {{-- CARD HEADER: Greeting dan Tombol Keluar --}}
        <div class="card-header gradient-header border-0 d-flex align-items-center justify-content-between p-4 pb-3">
            
            {{-- Greeting --}}
            <div class="flex-fill">
                <h3 class="mb-0 fw-bolder text-white greeting-text">
                    <span class="wave-emoji">👋</span> Halo, {{ $auth->name }}
                </h3>
                <p class="text-white-50 mb-0 mt-1 small">Selamat datang kembali!</p>
            </div>
            
            {{-- Logout Button --}}
            <div>
                <a href="{{ route('auth.logout') }}" class="btn btn-sm btn-light rounded-pill px-4 fw-bold logout-button">
                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                </a>
            </div>
        </div>
        
        <div class="card-body p-4 pt-4 body-pattern">
            {{-- Bagian Utama Catatan Keuangan --}}
            <div class="row">
                <div class="col-12">
                    {{-- Judul Aplikasi Utama --}}
                    <div class="title-section mb-4">
                        <h4 class="mb-1 text-gradient fw-bolder">
                            <i class="fas fa-wallet me-2"></i>{{ config('app.name', 'Catatan Keuangan') }}
                        </h4>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-chart-line me-1"></i>
                            Kelola semua catatan pemasukan dan pengeluaran Anda di sini.
                        </p>
                    </div>

                    {{-- Komponen Livewire Catatan Keuangan (CRUD) --}}
                    @livewire('financial-records-livewire')

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Gradient Header yang Lebih Colorful */
    .gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        position: relative;
        overflow: hidden;
    }
    
    .gradient-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 8s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1) rotate(0deg); }
        50% { transform: scale(1.1) rotate(180deg); }
    }

    /* Wave Animation untuk Emoji */
    .wave-emoji {
        display: inline-block;
        animation: wave 2s ease-in-out infinite;
    }
    
    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-20deg); }
    }

    /* Greeting Text dengan Shadow */
    .greeting-text {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    /* Gradient untuk judul dengan warna yang lebih berani */
    .text-gradient {
        background: linear-gradient(90deg, #f093fb 0%, #f5576c 50%, #ffd140 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.8rem;
        animation: gradientShift 3s ease infinite;
        background-size: 200% 200%;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Title Section dengan Border Colorful */
    .title-section {
        padding-bottom: 1rem;
        border-bottom: 3px solid;
        border-image: linear-gradient(90deg, #667eea, #764ba2, #f093fb) 1;
    }

    /* Pattern Background di Body */
    .body-pattern {
        background-color: #fafbff;
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.05) 0%, transparent 50%);
    }

    /* Efek visual pada Card Wrapper */
    .aesthetic-wrapper {
        border: 1px solid #e9ecef !important;
        box-shadow: 
            0 10px 30px rgba(102, 126, 234, 0.2),
            0 5px 15px rgba(240, 147, 251, 0.15) !important;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .aesthetic-wrapper:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 15px 40px rgba(102, 126, 234, 0.25),
            0 8px 20px rgba(240, 147, 251, 0.2) !important;
    }

    /* Tombol Keluar yang Lebih Modern */
    .logout-button {
        transition: all 0.3s ease;
        background-color: #ffffff !important;
        color: #667eea !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
        font-weight: 600 !important;
        position: relative;
        z-index: 1;
    }
    
    .logout-button:hover {
        background-color: #f8f9fa !important;
        color: #764ba2 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 255, 255, 0.4);
    }
    
    .logout-button i {
        transition: transform 0.3s ease;
    }
    
    .logout-button:hover i {
        transform: translateX(3px);
    }
</style>
@endpush