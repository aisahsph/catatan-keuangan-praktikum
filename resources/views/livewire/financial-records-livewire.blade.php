<div class="container py-4">
    {{-- Statistik --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card stat-card bg-success text-white border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        {{-- Icon aesthetic enhancement --}}
                        <div class="me-3 stat-icon bg-white text-success shadow-sm rounded-circle p-3">
                            <i class="fas fa-wallet fa-xl"></i>
                        </div>
                        <div>
                            <p class="card-text mb-1 fw-bold text-white-50">Total Pemasukan</p>
                            <h3 class="mb-0 fw-bolder">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-danger text-white border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3 stat-icon bg-white text-danger shadow-sm rounded-circle p-3">
                            <i class="fas fa-credit-card fa-xl"></i>
                        </div>
                        <div>
                            <p class="card-text mb-1 fw-bold text-white-50">Total Pengeluaran</p>
                            <h3 class="mb-0 fw-bolder">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-primary text-white border-0 shadow-lg rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3 stat-icon bg-white text-primary shadow-sm rounded-circle p-3">
                            <i class="fas fa-coins fa-xl"></i>
                        </div>
                        <div>
                            <p class="card-text mb-1 fw-bold text-white-50">Sisa Uang</p>
                            <h3 class="mb-0 fw-bolder">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="card shadow-sm mb-4 rounded-3 p-3">
        <div class="row g-3">
            {{-- Tambah Catatan: Dibuat lebih besar (btn-lg) --}}
            <div class="col-md-4 order-md-1 order-3">
                <button type="button" class="btn btn-primary btn-lg shadow-sm w-100 rounded-3" wire:click="$set('showForm', true)">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan
                </button>
            </div>
            {{-- Filter: Dibuat lebih besar (input-group-lg) dan rounded --}}
            <div class="col-md-4 order-md-2 order-1">
                <div class="input-group input-group-lg shadow-sm rounded-3">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                        <i class="fas fa-filter text-muted"></i>
                    </span>
                    <select id="chart-filter" wire:model.live="filter" class="form-select border-start-0 rounded-end-3">
                        <option value="">Semua Jenis</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
            </div>
            {{-- Pencarian: Dibuat lebih besar (input-group-lg) dan rounded --}}
            <div class="col-md-4 order-md-3 order-2">
                <div class="input-group input-group-lg shadow-sm rounded-3">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                        wire:model.live="search" 
                        class="form-control border-start-0 rounded-end-3" 
                        placeholder="Cari catatan...">
                </div>
            </div>
        </div>
    </div>

    {{-- Chart: Dibuat lebih modern dengan card shadow-lg --}}
    <div class="card shadow-lg mt-4 rounded-3">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="card-title fw-bolder text-dark">Grafik Keuangan</h5>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
                <p class="me-3 mb-0 fw-bold d-none d-sm-block">Tipe:</p>
                <div class="btn-group me-3" role="group" aria-label="Chart type">
                    <button type="button" class="btn btn-outline-primary active" onclick="updateChartType('line')">Line</button>
                </div>
                
                <p class="me-3 mb-0 fw-bold d-none d-sm-block">Periode:</p>
                <div class="btn-group" role="group" aria-label="Time period">
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('7d')">7 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('30d')">30 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('all')">Semua</button>
                </div>
            </div>
            <div id="financial-chart"></div>
        </div>
    </div>

    {{-- Tabel Catatan Keuangan: Dibuat lebih rapi dalam card --}}
    <div class="card shadow-lg mt-4 rounded-3">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="card-title fw-bolder text-dark">Daftar Transaksi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0 financial-table">
                    <thead class="bg-light">
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
                            <tr>
                                <td>{{ ($records->firstItem() + $loop->index) }}</td>
                                <td>{{ $record->transaction_date->format('d/m/Y') }}</td>
                                <td>
                                    {{-- Badge aesthetic enhancement --}}
                                    <span class="badge rounded-pill text-uppercase px-3 py-2 bg-{{ $record->type === 'income' ? 'success' : 'danger' }}">
                                        {{ $record->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-nowrap">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                                <td>{{ $record->title }}</td>
                                <td>{{ $record->category }}</td>
                                <td class="action-buttons text-center">
                                    {{-- Button aesthetic enhancement: compact and rounded --}}
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="showDetail({{ $record->id }})" class="btn btn-info rounded-start-pill" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:click="edit({{ $record->id }})" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $record->id }})" class="btn btn-danger rounded-end-pill" 
                                                onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada catatan keuangan yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINASI: Menampilkan tautan navigasi di bawah tabel --}}
            <div class="card-footer bg-white border-0">
                {{ $records->links() }}
            </div>
        </div>
    </div>


    {{-- Form Modal Tambah (Aesthetic Update) --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showForm ? 'block' : 'none' }}" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showForm', false)"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted"><i class="fas fa-tag me-2"></i>Jenis</label>
                                <select id="add-type" wire:model.live="type" class="form-select form-select-lg border-2 rounded-3">
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted"><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</label>
                                <input type="date" wire:model="transaction_date" class="form-control form-control-lg border-2 rounded-3">
                                @error('transaction_date') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-money-bill me-2"></i>Jumlah</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text rounded-start-3">Rp</span>
                                <input type="number" wire:model="amount" class="form-control border-2 rounded-end-3" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-heading me-2"></i>Judul</label>
                            <input type="text" wire:model="title" class="form-control form-control-lg border-2 rounded-3">
                            @error('title') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-folder me-2"></i>Kategori</label>
                            <select id="add-category" wire:model="category" class="form-select form-select-lg border-2 rounded-3">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                            <textarea wire:model="description" class="form-control border-2 rounded-3" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-image me-2"></i>Gambar Bukti</label>
                            <input type="file" wire:model="image" class="form-control border-2 rounded-3" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer bg-light border-0 rounded-bottom-4">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" wire:click="$set('showForm', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
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
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-warning text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showEditModal', false)"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted"><i class="fas fa-tag me-2"></i>Jenis</label>
                                <select id="edit-type" wire:model="type" class="form-select form-select-lg border-2 rounded-3">
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted"><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</label>
                                <input type="date" wire:model="transaction_date" class="form-control form-control-lg border-2 rounded-3">
                                @error('transaction_date') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-money-bill me-2"></i>Jumlah</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text rounded-start-3">Rp</span>
                                <input type="number" wire:model="amount" class="form-control border-2 rounded-end-3" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-heading me-2"></i>Judul</label>
                            <input type="text" wire:model="title" class="form-control form-control-lg border-2 rounded-3">
                            @error('title') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-folder me-2"></i>Kategori</label>
                            <select id="edit-category" wire:model="category" class="form-select form-select-lg border-2 rounded-3">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                            <textarea wire:model="description" class="form-control border-2 rounded-3" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted"><i class="fas fa-image me-2"></i>Gambar Bukti (Ubah)</label>
                            <input type="file" wire:model="image" class="form-control border-2 rounded-3" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 rounded-bottom-4">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" wire:click="$set('showEditModal', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill text-white px-4">
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
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-info text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-search me-2"></i>Detail Catatan Keuangan</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showDetailModal', false)"></button>
                </div>
                <div class="modal-body p-4">
                    @if($selectedRecord)
                        <div class="card p-3 bg-light border-0">
                            <dl class="row mb-0">
                                <dt class="col-sm-3 fw-bold text-muted">Judul</dt>
                                <dd class="col-sm-9">{{ $selectedRecord->title }}</dd>

                                <dt class="col-sm-3 fw-bold text-muted">Jenis</dt>
                                <dd class="col-sm-9"><span class="badge bg-{{ $selectedRecord->type === 'income' ? 'success' : 'danger' }} text-uppercase">{{ $selectedRecord->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span></dd>

                                <dt class="col-sm-3 fw-bold text-muted">Jumlah</dt>
                                <dd class="col-sm-9 fw-bolder text-primary">Rp {{ number_format($selectedRecord->amount, 0, ',', '.') }}</dd>

                                <dt class="col-sm-3 fw-bold text-muted">Kategori</dt>
                                <dd class="col-sm-9">{{ $selectedRecord->category }}</dd>

                                <dt class="col-sm-3 fw-bold text-muted">Tanggal</dt>
                                <dd class="col-sm-9">{{ $selectedRecord->transaction_date->format('d/m/Y') }}</dd>

                                <dt class="col-sm-3 fw-bold text-muted">Deskripsi</dt>
                                <dd class="col-sm-9">{{ $selectedRecord->description ?? '-' }}</dd>
                            </dl>
                        </div>

                        @if($selectedRecord->image_path)
                            <div class="mt-4">
                                <h6 class="fw-bold text-muted mb-2">Gambar Bukti:</h6>
                                <img src="{{ asset('storage/' . $selectedRecord->image_path) }}" alt="Gambar Bukti" class="img-fluid rounded-3 border shadow-sm"/>
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted">Tidak ada data untuk ditampilkan.</p>
                    @endif
                </div>
                <div class="modal-footer bg-light border-0 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" wire:click="$set('showDetailModal', false)">Tutup</button>
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
                seriesColors.push('#198754'); // success/green
            }
            if (!chartFilter || chartFilter === 'expense') {
                series.push({ name: 'Pengeluaran', data: expensePoints });
                seriesColors.push('#dc3545'); // danger/red
            }

                // If there are no date points at all, show a friendly placeholder instead of an empty chart
                const chartContainer = document.querySelector('#financial-chart');
                if (!dates || dates.length === 0) {
                    if (chartContainer) {
                        chartContainer.innerHTML = '<div class="text-center py-5 text-muted">Tidak ada data grafik untuk periode/jenis yang dipilih.</div>';
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
                    size: 4
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
    /* Global Aesthetic Improvements */
    .container { max-width: 1400px; }
    .card { border: none; transition: transform 0.2s, box-shadow 0.2s; }
    .card-header { background: transparent; border-bottom: 0; }
    .card-title { font-weight: 800; } /* Extra bold for titles */
    .shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.05) !important; } /* Softer, larger shadow */
    .rounded-3 { border-radius: 0.75rem !important; }
    .rounded-4 { border-radius: 1.25rem !important; } /* More rounded for modals */

    /* Stat Card Specifics */
    .stat-card {
        transform: translateY(0);
    }
    .stat-card:hover {
        transform: translateY(-3px); /* subtle lift on hover */
        box-shadow: 0 1rem 3rem rgba(0,0,0,.15) !important;
    }
    .stat-card .stat-icon {
        color: #fff; /* Ensure icon is white when card is colored */
    }
    .stat-card .bg-success .stat-icon { color: #198754 !important; }
    .stat-card .bg-danger .stat-icon { color: #dc3545 !important; }
    .stat-card .bg-primary .stat-icon { color: #0d6efd !important; }
    .stat-card h3 { font-size: 1.75rem; }

    /* Forms and Filters */
    .form-control-lg, .form-select-lg, .btn-lg {
        height: calc(3.5rem + 2px); /* Taller inputs for better touch experience */
    }
    .input-group-text { background-color: #f8f9fa !important; }
    .form-control, .form-select {
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Table Specifics */
    .financial-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .financial-table thead th {
        background-color: #f1f2f6; /* Lighter shade of light */
        color: #333;
        font-weight: 700;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem 1rem;
    }
    .financial-table tbody tr {
        border-bottom: 1px solid #f8f9fa; /* minimal row separator */
    }
    .financial-table tbody tr:last-child {
        border-bottom: none;
    }
    .financial-table tbody tr:hover {
        background-color: #f7f7f7;
    }
    .financial-table td {
        padding: 1rem 1rem;
    }
    
    /* Action Buttons (Mobile Consistency) */
    .action-buttons .btn-group-sm .btn {
        padding: 0.5rem 0.65rem;
        font-size: 0.8rem;
    }
    /* Ensure action buttons are small and compact on all screens */

    /* Chart Buttons */
    .btn-group .btn {
        border-radius: 0.5rem;
    }
    .btn-outline-primary.active, .btn-outline-primary:hover { 
        background-color: #0d6efd; 
        color: #fff; 
        border-color: #0d6efd; 
    }
    .btn-outline-secondary.active, .btn-outline-secondary:hover { 
        background-color: #6c757d; 
        color: #fff; 
        border-color: #6c757d; 
    }

    /* Modal Styling */
    .modal-content {
        border: none;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Image detail in Modal */
    .img-fluid { 
        max-width: 100%; 
        height: auto; 
        max-height: 300px;
        object-fit: cover;
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