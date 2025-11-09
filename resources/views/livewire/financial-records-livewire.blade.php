<div class="container py-4">
    {{-- Statistik --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card stat-card stat-card-success border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        {{-- Icon aesthetic enhancement --}}
                        <div class="me-3 stat-icon-wrapper">
                            <div class="stat-icon bg-white shadow-sm rounded-circle p-3">
                                <i class="fas fa-wallet fa-xl text-success"></i>
                            </div>
                        </div>
                        <div class="stat-content flex-grow-1">
                            <p class="card-text mb-1 fw-bold stat-label">Total Pemasukan</p>
                            <h3 class="mb-0 fw-bolder stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-decoration"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card stat-card-danger border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3 stat-icon-wrapper">
                            <div class="stat-icon bg-white shadow-sm rounded-circle p-3">
                                <i class="fas fa-credit-card fa-xl text-danger"></i>
                            </div>
                        </div>
                        <div class="stat-content flex-grow-1">
                            <p class="card-text mb-1 fw-bold stat-label">Total Pengeluaran</p>
                            <h3 class="mb-0 fw-bolder stat-value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-decoration"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card stat-card-primary border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3 stat-icon-wrapper">
                            <div class="stat-icon bg-white shadow-sm rounded-circle p-3">
                                <i class="fas fa-coins fa-xl text-primary"></i>
                            </div>
                        </div>
                        <div class="stat-content flex-grow-1">
                            <p class="card-text mb-1 fw-bold stat-label">Sisa Uang</p>
                            <h3 class="mb-0 fw-bolder stat-value">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-decoration"></div>
            </div>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="card shadow-modern mb-4 rounded-4 p-4 filter-card">
        <div class="row g-3">
            {{-- Tambah Catatan: Dibuat lebih besar (btn-lg) --}}
            <div class="col-md-4 order-md-1 order-3">
                <button type="button" class="btn btn-gradient-primary btn-lg shadow-btn w-100 rounded-pill" wire:click="$set('showForm', true)">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Catatan
                </button>
            </div>
            {{-- Filter: Dibuat lebih besar (input-group-lg) dan rounded --}}
            <div class="col-md-4 order-md-2 order-1">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-gradient-light border-0">
                        <i class="fas fa-filter text-primary"></i>
                    </span>
                    <select id="chart-filter" wire:model.live="filter" class="form-select border-0 custom-select">
                        <option value="">Semua Jenis</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
            </div>
            {{-- Pencarian: Dibuat lebih besar (input-group-lg) dan rounded --}}
            <div class="col-md-4 order-md-3 order-2">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-gradient-light border-0">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input type="text" 
                        wire:model.live="search" 
                        class="form-control border-0" 
                        placeholder="Cari catatan...">
                </div>
            </div>
        </div>
    </div>

    {{-- Chart: Dibuat lebih modern dengan card shadow-lg --}}
    <div class="card shadow-modern rounded-4 chart-card">
        <div class="card-header bg-gradient-header border-0 pt-4 pb-3">
            <h5 class="card-title fw-bolder text-white mb-0">
                <i class="fas fa-chart-line me-2"></i>Grafik Keuangan
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
                <p class="me-2 mb-0 fw-bold text-gradient-primary d-none d-sm-block">Tipe:</p>
                <div class="btn-group me-3" role="group" aria-label="Chart type">
                    <button type="button" class="btn btn-outline-gradient active" onclick="updateChartType('line')">Line</button>
                </div>
                
                <p class="me-2 mb-0 fw-bold text-gradient-primary d-none d-sm-block">Periode:</p>
                <div class="btn-group" role="group" aria-label="Time period">
                    <button type="button" class="btn btn-outline-gradient" onclick="updateChartPeriod('7d')">7 Hari</button>
                    <button type="button" class="btn btn-outline-gradient" onclick="updateChartPeriod('30d')">30 Hari</button>
                    <button type="button" class="btn btn-outline-gradient" onclick="updateChartPeriod('all')">Semua</button>
                </div>
            </div>
            <div id="financial-chart"></div>
        </div>
    </div>

    {{-- Tabel Catatan Keuangan: Dibuat lebih rapi dalam card --}}
    <div class="card shadow-modern mt-4 rounded-4 table-card">
        <div class="card-header bg-gradient-header border-0 pt-4 pb-3">
            <h5 class="card-title fw-bolder text-white mb-0">
                <i class="fas fa-list me-2"></i>Daftar Transaksi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 financial-table">
                    <thead class="table-header-gradient">
                        <tr>
                            <th>No</th>
                            <th wire:click="sortBy('transaction_date')" style="cursor: pointer">
                                Tanggal
                                @if ($sortField === 'transaction_date')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th>Jenis</th>
                            <th wire:click="sortBy('amount')" style="cursor: pointer">
                                Jumlah
                                @if ($sortField === 'amount')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr class="table-row-hover">
                                <td>{{ ($records->firstItem() + $loop->index) }}</td>
                                <td>{{ $record->transaction_date->format('d/m/Y') }}</td>
                                <td>
                                    {{-- Badge aesthetic enhancement --}}
                                    <span class="badge badge-gradient rounded-pill text-uppercase px-3 py-2 badge-{{ $record->type === 'income' ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $record->type === 'income' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                        {{ $record->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-nowrap amount-text">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                                <td>{{ $record->title }}</td>
                                <td><span class="badge bg-light text-dark">{{ $record->category }}</span></td>
                                <td class="action-buttons text-center">
                                    {{-- Button aesthetic enhancement: compact and rounded --}}
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="showDetail({{ $record->id }})" class="btn btn-info-gradient rounded-start-pill" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:click="edit({{ $record->id }})" class="btn btn-warning-gradient" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $record->id }})" class="btn btn-danger-gradient rounded-end-pill" 
                                                onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Tidak ada catatan keuangan yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINASI: Menampilkan tautan navigasi di bawah tabel --}}
            <div class="card-footer bg-white border-0 py-3">
                {{ $records->links() }}
            </div>
        </div>
    </div>


    {{-- Form Modal Tambah (Aesthetic Update) --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showForm ? 'block' : 'none' }}" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg rounded-4 modal-gradient">
                <div class="modal-header bg-gradient-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showForm', false)"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body p-4 bg-light-gradient">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-tag me-2"></i>Jenis</label>
                                <select id="add-type" wire:model.live="type" class="form-select form-select-lg border-gradient rounded-3">
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</label>
                                <input type="date" wire:model="transaction_date" class="form-control form-control-lg border-gradient rounded-3">
                                @error('transaction_date') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-money-bill me-2"></i>Jumlah</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-gradient-light rounded-start-3 fw-bold">Rp</span>
                                <input type="number" wire:model="amount" class="form-control border-gradient rounded-end-3" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-heading me-2"></i>Judul</label>
                            <input type="text" wire:model="title" class="form-control form-control-lg border-gradient rounded-3">
                            @error('title') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-folder me-2"></i>Kategori</label>
                            <select id="add-category" wire:model="category" class="form-select form-select-lg border-gradient rounded-3">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                            <textarea wire:model="description" class="form-control border-gradient rounded-3" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-image me-2"></i>Gambar Bukti</label>
                            <input type="file" wire:model="image" class="form-control border-gradient rounded-3" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer bg-white border-0 rounded-bottom-4">
                        <button type="button" class="btn btn-gradient-secondary rounded-pill px-4" wire:click="$set('showForm', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal (Aesthetic Update - Matched Add Modal) --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showEditModal ? 'block' : 'none' }}" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg rounded-4 modal-gradient">
                <div class="modal-header bg-gradient-warning text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showEditModal', false)"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body p-4 bg-light-gradient">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-tag me-2"></i>Jenis</label>
                                <select id="edit-type" wire:model="type" class="form-select form-select-lg border-gradient rounded-3">
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</label>
                                <input type="date" wire:model="transaction_date" class="form-control form-control-lg border-gradient rounded-3">
                                @error('transaction_date') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-money-bill me-2"></i>Jumlah</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-gradient-light rounded-start-3 fw-bold">Rp</span>
                                <input type="number" wire:model="amount" class="form-control border-gradient rounded-end-3" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-heading me-2"></i>Judul</label>
                            <input type="text" wire:model="title" class="form-control form-control-lg border-gradient rounded-3">
                            @error('title') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-folder me-2"></i>Kategori</label>
                            <select id="edit-category" wire:model="category" class="form-select form-select-lg border-gradient rounded-3">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                            <textarea wire:model="description" class="form-control border-gradient rounded-3" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-gradient-primary"><i class="fas fa-image me-2"></i>Gambar Bukti (Ubah)</label>
                            <input type="file" wire:model="image" class="form-control border-gradient rounded-3" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-white border-0 rounded-bottom-4">
                        <button type="button" class="btn btn-gradient-secondary rounded-pill px-4" wire:click="$set('showEditModal', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-gradient-warning rounded-pill text-white px-4">
                            <i class="fas fa-sync-alt me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Detail Modal (Aesthetic Update) --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showDetailModal ? 'block' : 'none' }}" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg rounded-4 modal-gradient">
                <div class="modal-header bg-gradient-info text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-search me-2"></i>Detail Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showDetailModal', false)"></button>
                </div>
                <div class="modal-body p-4 bg-light-gradient">
                    @if($selectedRecord)
                        <div class="card p-4 bg-white border-0 shadow-sm rounded-3">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-heading me-2"></i>Judul
                                </dt>
                                <dd class="col-sm-8 mb-2">{{ $selectedRecord->title }}</dd>

                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-tag me-2"></i>Jenis
                                </dt>
                                <dd class="col-sm-8 mb-2">
                                    <span class="badge badge-gradient badge-{{ $selectedRecord->type === 'income' ? 'success' : 'danger' }} text-uppercase px-3 py-2">
                                        <i class="fas fa-{{ $selectedRecord->type === 'income' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                        {{ $selectedRecord->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-money-bill me-2"></i>Jumlah
                                </dt>
                                <dd class="col-sm-8 mb-2 fw-bolder text-success fs-5">Rp {{ number_format($selectedRecord->amount, 0, ',', '.') }}</dd>

                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-folder me-2"></i>Kategori
                                </dt>
                                <dd class="col-sm-8 mb-2">
                                    <span class="badge bg-light text-dark px-3 py-2">{{ $selectedRecord->category }}</span>
                                </dd>

                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-calendar me-2"></i>Tanggal
                                </dt>
                                <dd class="col-sm-8 mb-2">{{ $selectedRecord->transaction_date->format('d/m/Y') }}</dd>

                                <dt class="col-sm-4 fw-bold text-gradient-primary mb-2">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi
                                </dt>
                                <dd class="col-sm-8 mb-0">{{ $selectedRecord->description ?? '-' }}</dd>
                            </dl>
                        </div>

                        @if($selectedRecord->image_path)
                            <div class="mt-4">
                                <h6 class="fw-bold text-gradient-primary mb-3">
                                    <i class="fas fa-image me-2"></i>Gambar Bukti:
                                </h6>
                                <img src="{{ asset('storage/' . $selectedRecord->image_path) }}" alt="Gambar Bukti" class="img-fluid rounded-3 border shadow-sm w-100"/>
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted">Tidak ada data untuk ditampilkan.</p>
                    @endif
                </div>
                <div class="modal-footer bg-white border-0 rounded-bottom-4">
                    <button type="button" class="btn btn-gradient-secondary rounded-pill px-4" wire:click="$set('showDetailModal', false)">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- We'll keep the chart in the first section where the buttons are already defined --}}

    @push('scripts')
    <script>
    let chart;
    let currentPeriod = 'all';
    // Use line chart only per user's request
    let currentType = 'line';
        
        // We'll read chart data from a hidden DOM element so Livewire updates refresh the dataset
        // Data format: [{x: 'YYYY-MM-DD', y: number}, ...]
        function readOriginalDataFromDom() {
            const el = document.getElementById('chart-data');
            if (!el) return { income: [], expense: [] };
            try {
                return {
                    income: JSON.parse(el.dataset.income || '[]'),
                    expense: JSON.parse(el.dataset.expense || '[]')
                };
            } catch (e) {
                return { income: [], expense: [] };
            }
        }

        // Aggregate multiple records on the same date by summing y values
        function aggregateByDate(points) {
            const map = {};
            points.forEach(p => {
                const d = p.x; // 'YYYY-MM-DD'
                if (!map[d]) map[d] = 0;
                map[d] += Number(p.y || 0);
            });
            // convert back to sorted array of {x,y}
            return Object.keys(map).sort().map(d => ({ x: d, y: map[d] }));
        }

        // compute aggregatedOriginal from DOM data (will be recomputed after Livewire updates)
        function recomputeAggregatedOriginal() {
            const originalData = readOriginalDataFromDom();
            return {
                income: aggregateByDate(originalData.income || []),
                expense: aggregateByDate(originalData.expense || [])
            };
        }

        let aggregatedOriginal = recomputeAggregatedOriginal();

        // Categories from server (income/expense)
        const categories = @json($categories);

        function populateCategoryOptions(selectEl, type) {
            if (!selectEl) return;
            // clear existing options
            selectEl.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih kategori';
            selectEl.appendChild(defaultOption);
            (categories[type] || []).forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat;
                opt.textContent = cat;
                selectEl.appendChild(opt);
            });
        }

        // wire up add/edit modal selects for instant client-side update
        document.addEventListener('DOMContentLoaded', () => {
            const addType = document.getElementById('add-type');
            const addCategory = document.getElementById('add-category');
            const editType = document.getElementById('edit-type');
            const editCategory = document.getElementById('edit-category');

            if (addType && addCategory) {
                populateCategoryOptions(addCategory, addType.value || 'expense');
                addType.addEventListener('change', (e) => {
                    populateCategoryOptions(addCategory, e.target.value);
                    addCategory.value = '';
                    addCategory.dispatchEvent(new Event('change'));
                });
            }

            if (editType && editCategory) {
                populateCategoryOptions(editCategory, editType.value || 'expense');
                editType.addEventListener('change', (e) => {
                    populateCategoryOptions(editCategory, e.target.value);
                    editCategory.value = '';
                    editCategory.dispatchEvent(new Event('change'));
                });
            }
        });

        // keep selects in sync after Livewire updates (server-side changes)
        document.addEventListener('livewire:update', () => {
            const addType = document.getElementById('add-type');
            const addCategory = document.getElementById('add-category');
            const editType = document.getElementById('edit-type');
            const editCategory = document.getElementById('edit-category');
            if (addType && addCategory) populateCategoryOptions(addCategory, addType.value || 'expense');
            if (editType && editCategory) populateCategoryOptions(editCategory, editType.value || 'expense');
        });

        // Filter data berdasarkan periode (period: '7d','30d','all')
        function filterDataByPeriod(period) {
            const daysToSubtract = period === '7d' ? 7 : period === '30d' ? 30 : null;
            let cutoffDate = null;
            if (daysToSubtract) {
                cutoffDate = new Date();
                cutoffDate.setDate(cutoffDate.getDate() - daysToSubtract);
                cutoffDate.setHours(0,0,0,0);
            }

            const filtered = { income: [], expense: [] };

            ['income','expense'].forEach(type => {
                aggregatedOriginal[type].forEach(pt => {
                    const recordDate = new Date(pt.x + 'T00:00:00');
                    if (!cutoffDate || recordDate >= cutoffDate) {
                        filtered[type].push(pt);
                    }
                });
            });

            return filtered;
        }

        // Update tampilan grafik
        function updateChart(data) {
            // Ensure both series share the same set of dates (union), filling missing with 0
            const dateSet = new Set();
            data.income.forEach(p => dateSet.add(p.x));
            data.expense.forEach(p => dateSet.add(p.x));
            const dates = Array.from(dateSet).sort(); // 'YYYY-MM-DD' sorts correctly

            const incomeMap = Object.fromEntries(data.income.map(p => [p.x, p.y]));
            const expenseMap = Object.fromEntries(data.expense.map(p => [p.x, p.y]));

            const incomePoints = dates.map(d => ({ x: d, y: incomeMap[d] || 0 }));
            const expensePoints = dates.map(d => ({ x: d, y: expenseMap[d] || 0 }));

            // read the chart filter (show only income or expense) from the select
            function getChartFilterValue() {
                const el = document.getElementById('chart-filter');
                return el ? el.value : '';
            }

            const chartFilter = getChartFilterValue();

                // Build series array depending on chartFilter
            const series = [];
            const seriesColors = [];
            if (!chartFilter || chartFilter === 'income') {
                series.push({ name: 'Pemasukan', data: incomePoints });
                seriesColors.push('#10b981'); // green gradient
            }
            if (!chartFilter || chartFilter === 'expense') {
                series.push({ name: 'Pengeluaran', data: expensePoints });
                seriesColors.push('#ef4444'); // red gradient
            }

                // If there are no date points at all, show a friendly placeholder instead of an empty chart
                const chartContainer = document.querySelector('#financial-chart');
                if (!dates || dates.length === 0) {
                    if (chartContainer) {
                        chartContainer.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-chart-line fa-3x mb-3 d-block opacity-25"></i><p class="mb-0">Tidak ada data grafik untuk periode/jenis yang dipilih.</p></div>';
                    }
                    return;
                }

            // Use series with {x: 'YYYY-MM-DD', y: value} so ApexCharts maps points by datetime
            const options = {
                chart: {
                    type: currentType,
                    height: 350,
                    // Disable zoom/pan/selection to keep chart static (date-only)
                    zoom: { enabled: false },
                    toolbar: { show: false }
                },
                // Do not include the net series in the chart to keep it simple and as requested
                series: series,
                // disable data labels inside the chart so numbers won't appear (and thus avoid white text on bars)
                dataLabels: { enabled: false },
                xaxis: {
                    type: 'datetime',
                    // show a tick for each date in the dataset so all table dates appear
                    tickAmount: Math.max(dates.length - 1, 1),
                    labels: {
                        datetimeUTC: false,
                        rotate: -45,
                        formatter: function(value) {
                            const d = new Date(value);
                            return d.toLocaleDateString('id-ID');
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                tooltip: {
                    x: {
                        formatter: function(val) {
                            const d = new Date(val);
                            return d.toLocaleDateString('id-ID');
                        }
                    },
                    y: {
                        formatter: function(val) {
                            return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                colors: seriesColors,
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5
                }
            };

            if (chart) {
                chart.destroy();
            }
            
            chart = new ApexCharts(document.querySelector("#financial-chart"), options);
            chart.render();
        }

        // Handler untuk mengubah tipe grafik
        function updateChartType(type) {
            currentType = type;
            const filteredData = filterDataByPeriod(currentPeriod);
            updateChart(filteredData);
            
            // Update active state pada tombol
            document.querySelectorAll('[onclick^="updateChartType"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(type)) {
                    btn.classList.add('active');
                }
            });
        }

        // Handler untuk mengubah periode
        function updateChartPeriod(period) {
            currentPeriod = period;
            const filteredData = filterDataByPeriod(currentPeriod);
            updateChart(filteredData);
            
            // Update active state pada tombol
            document.querySelectorAll('[onclick^="updateChartPeriod"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(period)) {
                    btn.classList.add('active');
                }
            });
        }

    // Initialize chart dengan aggregated data awal (daily sums)
    // ensure chart respects the current filter (e.g., show only pemasukan)
    updateChart(aggregatedOriginal);

    // listen to changes on the filter select to update chart accordingly
    function attachFilterListener() {
        const filterEl = document.getElementById('chart-filter');
        if (!filterEl) return;
        // remove any existing handler by cloning (avoids duplicates after Livewire re-renders)
        const newEl = filterEl.cloneNode(true);
        filterEl.parentNode.replaceChild(newEl, filterEl);
        newEl.addEventListener('change', () => {
            const filteredData = filterDataByPeriod(currentPeriod);
            updateChart(filteredData);
        });
    }

    document.addEventListener('DOMContentLoaded', () => attachFilterListener());

    // also update after Livewire updates (in case server-side filter changed)
    document.addEventListener('livewire:update', () => {
        // Ensure filter listener reattached after Livewire DOM replace
        attachFilterListener();
        // re-read chart JSON that the server embedded in #chart-data
        aggregatedOriginal = recomputeAggregatedOriginal();
        const filterEl = document.getElementById('chart-filter');
        if (filterEl) {
            const filteredData = filterDataByPeriod(currentPeriod);
            updateChart(filteredData);
        } else {
            // if no filter element for some reason, still redraw chart with current aggregated data
            updateChart(aggregatedOriginal);
        }
    });

        // set active classes on buttons based on currentType/currentPeriod
        function setActiveButtons() {
            document.querySelectorAll('[onclick^="updateChartType"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(currentType)) {
                    btn.classList.add('active');
                }
            });
            document.querySelectorAll('[onclick^="updateChartPeriod"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(currentPeriod)) {
                    btn.classList.add('active');
                }
            });
        }

        // ensure active states set after render
        document.addEventListener('DOMContentLoaded', () => setActiveButtons());
        // Also set after Livewire updates
        document.addEventListener('livewire:update', () => setActiveButtons());

        // Initialize SweetAlert2 (handle payload as Livewire emit or browser event)
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('swal', (params) => {
                const payload = Array.isArray(params) ? params[0] : params;
                if (!payload) return;
                Swal.fire({
                    icon: payload.icon,
                    title: payload.title,
                    text: payload.text
                });
            });
        });

        // Also listen for browser events dispatched via dispatchBrowserEvent
        window.addEventListener('swal', (e) => {
            const payload = e.detail;
            if (!payload) return;
            Swal.fire({
                icon: payload.icon,
                title: payload.title,
                text: payload.text
            });
        });
    </script>
    @endpush

@push('styles')
    <style>
    /* ========== GLOBAL STYLES ========== */
    .container { max-width: 1400px; }
    
    /* ========== GRADIENT UTILITIES ========== */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    }
    .bg-gradient-light {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
    }
    .bg-gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        position: relative;
        overflow: hidden;
    }
    .bg-gradient-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse-header 8s ease-in-out infinite;
    }
    @keyframes pulse-header {
        0%, 100% { transform: scale(1) rotate(0deg); }
        50% { transform: scale(1.1) rotate(180deg); }
    }
    
    .text-gradient-primary {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .bg-light-gradient {
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    }
    
    /* ========== STAT CARDS ========== */
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        min-height: 140px;
    }
    
    .stat-card-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .stat-card-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .stat-card-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
    }
    
    .stat-decoration {
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .stat-icon-wrapper {
        flex-shrink: 0;
        z-index: 1;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .stat-label {
        color: rgba(255, 255, 255, 0.9) !important;
        font-size: 0.9rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    
    .stat-value {
        color: white !important;
        font-size: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        word-break: break-word;
    }
    
    /* Responsive untuk stat cards */
    @media (max-width: 768px) {
        .stat-card {
            min-height: 120px;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
        }
        .stat-icon i {
            font-size: 1.2rem !important;
        }
        .stat-label {
            font-size: 0.8rem;
        }
        .stat-value {
            font-size: 1.2rem;
        }
    }
    
    /* ========== CARDS & SHADOWS ========== */
    .shadow-modern {
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15), 0 5px 15px rgba(240, 147, 251, 0.1) !important;
    }
    
    .card {
        border: none;
        transition: all 0.3s ease;
    }
    
    .filter-card, .chart-card, .table-card {
        position: relative;
        overflow: hidden;
    }
    
    .filter-card:hover, .chart-card:hover, .table-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2), 0 8px 20px rgba(240, 147, 251, 0.15) !important;
    }
    
    /* ========== BUTTONS ========== */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-gradient-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-gradient-secondary:hover {
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-gradient-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        transform: translateY(-2px);
        color: white;
    }
    
    .shadow-btn {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    /* ========== TABLE ACTION BUTTONS ========== */
    .btn-info-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-info-gradient:hover {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        color: white;
    }
    
    .btn-warning-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-warning-gradient:hover {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        color: white;
    }
    
    .btn-danger-gradient {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-danger-gradient:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
    }
    
    /* ========== CHART BUTTONS ========== */
    .btn-outline-gradient {
        border: 2px solid #667eea;
        color: #667eea;
        background: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }
    
    .btn-outline-gradient:hover, .btn-outline-gradient.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }
    
    /* ========== FORMS & INPUTS ========== */
    .form-control-lg, .form-select-lg {
        height: calc(3.5rem + 2px);
        font-size: 1rem;
    }
    
    .border-gradient {
        border: 2px solid #e5e7eb !important;
        transition: all 0.3s ease;
    }
    
    .border-gradient:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
    }
    
    .custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
    
    /* ========== TABLE ========== */
    .financial-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-header-gradient {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }
    
    .table-header-gradient th {
        color: #374151;
        font-weight: 700;
        border-bottom: 3px solid #667eea;
        padding: 1.2rem 1rem;
        position: relative;
    }
    
    .table-row-hover {
        transition: all 0.2s ease;
    }
    
    .table-row-hover:hover {
        background: linear-gradient(90deg, #f9fafb 0%, #f3f4f6 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .financial-table td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .amount-text {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* ========== BADGES ========== */
    .badge-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    .badge-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    .badge-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    /* ========== MODAL ========== */
    .modal-gradient {
        border: none;
        overflow: hidden;
    }
    
    .modal-gradient .modal-header h5 {
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }
    
    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .stat-content {
            min-width: 0;
        }
        
        .action-buttons .btn-group {
            display: flex;
            gap: 2px;
        }
        
        .action-buttons .btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }
        
        .financial-table {
            font-size: 0.85rem;
        }
        
        .financial-table td,
        .financial-table th {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-lg {
            height: auto;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
        
        .input-group-lg .form-control,
        .input-group-lg .form-select,
        .input-group-lg .input-group-text {
            height: auto;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.4rem 0.6rem !important;
        }
    }
    
    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        animation: fadeIn 0.5s ease;
    }
    </style>
@endpush

{{-- Hidden container for server-driven SweetAlert payload (Livewire updates this attribute) --}}
<div id="swal-data" style="display:none" data-swal='@json($swal)'></div>

{{-- Hidden container for chart data so JS can read updated JSON after Livewire re-renders --}}
<div id="chart-data" style="display:none"
    data-income='@json(($chartRecords->where('type', 'income')->map(function($r){ return ['x' => $r->transaction_date->format('Y-m-d'), 'y' => (float) $r->amount]; })->values()) ?? [])'
    data-expense='@json(($chartRecords->where('type', 'expense')->map(function($r){ return ['x' => $r->transaction_date->format('Y-m-d'), 'y' => (float) $r->amount]; })->values()) ?? [])'>
</div>

<script>
    // Fallback listener that reads the hidden data attribute after Livewire updates
    function readSwalDataAndShow() {
        const el = document.getElementById('swal-data');
        if (!el) return;
        let raw = el.getAttribute('data-swal');
        if (!raw || raw === 'null' || raw === '{}' || raw === '[]') return;
        try {
            const payload = JSON.parse(raw);
            if (payload && payload.title) {
                Swal.fire({
                    icon: payload.icon || 'info',
                    title: payload.title,
                    text: payload.text || ''
                });
                // clear client-side to avoid repeat until server updates again
                el.setAttribute('data-swal', 'null');
            }
        } catch (e) {
            // ignore parse errors
        }
    }

    document.addEventListener('DOMContentLoaded', () => readSwalDataAndShow());
    document.addEventListener('livewire:update', () => readSwalDataAndShow());
</script>