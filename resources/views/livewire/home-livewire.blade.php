<div class="mt-4">
    <div class="card border-0 shadow-lg rounded-4 aesthetic-wrapper">
        {{-- CARD HEADER: Greeting dan Tombol Keluar --}}
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between p-4 pb-2">
            
            {{-- Greeting --}}
            <div class="flex-fill">
                <h3 class="mb-0 fw-bolder text-gradient">👋 Halo, {{ $auth->name }}</h3>
            </div>
            
            {{-- Logout Button --}}
            <div>
                <a href="{{ route('auth.logout') }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold logout-button">
                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                </a>
            </div>
        </div>
        
        <div class="card-body p-4 pt-2">
            {{-- Bagian Utama Catatan Keuangan --}}
            <div class="row">
                <div class="col-12">
                    {{-- Judul Aplikasi Utama --}}
                    <h4 class="mb-1 text-primary fw-bolder">{{ config('app.name', 'Catatan Keuangan') }}</h4>
                    <p class="text-muted small mb-4">Kelola semua catatan pemasukan dan pengeluaran Anda di sini.</p>

                    {{-- Komponen Livewire Catatan Keuangan (CRUD) --}}
                    @livewire('financial-records-livewire')

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Gradient untuk judul (Memberikan kesan warna-warni) */
    .text-gradient {
        background: linear-gradient(90deg, #007bff, #6f42c1); /* Biru ke Ungu */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.8rem; /* Sedikit lebih besar */
    }

    /* Efek visual pada Card Wrapper */
    .aesthetic-wrapper {
        border: 1px solid #e9ecef !important; /* Border halus */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important; /* Shadow yang lebih dalam */
        overflow: hidden; /* Memastikan konten rapi di dalam border-radius */
    }

    /* Tombol Keluar yang Lebih Berani */
    .logout-button {
        transition: all 0.3s ease;
        background-color: #dc3545 !important; /* Warna merah yang jelas */
        border-color: #dc3545 !important;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
    }
    .logout-button:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.3);
    }
</style>
@endpush