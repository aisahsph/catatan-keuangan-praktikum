<style>
    .financial-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .financial-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: none;
        overflow: hidden;
        backdrop-filter: blur(10px);
        animation: fadeInUp 0.6s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .financial-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        padding: 2rem;
        color: white;
        border-bottom: none;
    }
    
    .financial-header h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.8rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn-logout {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .btn-logout:hover {
        background: white;
        color: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .financial-body {
        padding: 2.5rem;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
    }
    
    .title-section h4 {
        font-weight: 700;
        font-size: 1.6rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .title-section p {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    
    .content-wrapper {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .content-wrapper:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    /* Decorative elements */
    .financial-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .financial-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }
</style>

<div class="financial-container">
    <div class="container">
        <div class="mt-3">
            <div class="card financial-card">
                <div class="card-header financial-header d-flex position-relative">
                    <div class="flex-fill">
                        <h3>Hay, {{ $auth->name }}</h3>
                    </div>
                    <div>
                        <a href="{{ route('auth.logout') }}" class="btn btn-logout">Keluar</a>
                    </div>
                </div>
                <div class="card-body financial-body">
                    {{-- Bagian Utama Catatan Keuangan --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="title-section">
                                <h4 class="mb-4">{{ config('app.name', 'Catatan Keuangan') }}</h4>
                                <p class="text-muted">Kelola semua catatan pemasukan dan pengeluaran Anda di sini.</p>
                            </div>

                            <div class="content-wrapper">
                                {{-- Komponen Livewire Catatan Keuangan (CRUD) --}}
                                @livewire('financial-records-livewire')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>