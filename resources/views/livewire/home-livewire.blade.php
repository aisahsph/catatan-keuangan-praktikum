<div class="mt-3">
    <div class="card">
        <div class="card-header d-flex">
            <div class="flex-fill">
                <h3>Hay, {{ $auth->name }}</h3>
            </div>
            <div>
                <a href="{{ route('auth.logout') }}" class="btn btn-warning">Keluar</a>
            </div>
        </div>
        <div class="card-body">
            {{-- Bagian Utama Catatan Keuangan --}}
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-4 text-primary">{{ config('app.name', 'Catatan Keuangan') }}</h4>
                    <p class="text-muted">Kelola semua catatan pemasukan dan pengeluaran Anda di sini.</p>

                    {{-- Komponen Livewire Catatan Keuangan (CRUD) --}}
                    @livewire('financial-records-livewire')

                </div>
            </div>
        </div>
    </div>
</div>