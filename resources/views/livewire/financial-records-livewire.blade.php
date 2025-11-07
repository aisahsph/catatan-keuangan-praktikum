<div class="container py-5">
    {{-- Statistik --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card bg-success text-white border-0 shadow-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label mb-2 opacity-75">Total Pemasukan</p>
                            <h3 class="stat-value mb-0 fw-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
                <div class="card-shine"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-danger text-white border-0 shadow-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label mb-2 opacity-75">Total Pengeluaran</p>
                            <h3 class="stat-value mb-0 fw-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="card-shine"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-primary text-white border-0 shadow-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label mb-2 opacity-75">Sisa Uang</p>
                            <h3 class="stat-value mb-0 fw-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                </div>
                <div class="card-shine"></div>
            </div>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <button type="button" class="btn btn-primary btn-action shadow-sm w-100" wire:click="$set('showForm', true)">
                <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan
            </button>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-modern shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-filter text-primary"></i>
                </span>
                <select id="chart-filter" wire:model.live="filter" class="form-select border-start-0">
                    <option value="">Semua Jenis</option>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-modern shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text" 
                    wire:model.live="search" 
                    class="form-control border-start-0" 
                    placeholder="Cari catatan...">
            </div>
        </div>
    </div>

    {{-- Tabel Catatan Keuangan --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="card-title mb-0 fw-bold text-dark">
                <i class="fas fa-list-alt me-2 text-primary"></i>Daftar Transaksi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px">No</th>
                            <th wire:click="sortBy('transaction_date')" class="sortable">
                                Tanggal
                                @if ($sortField === 'transaction_date')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Jenis</th>
                            <th wire:click="sortBy('amount')" class="sortable">
                                Jumlah
                                @if ($sortField === 'amount')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th class="text-center" style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr class="table-row-hover">
                                <td class="text-center fw-semibold text-muted">{{ ($records->firstItem() + $loop->index) }}</td>
                                <td>
                                    <span class="text-dark">{{ $record->transaction_date->format('d/m/Y') }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-modern bg-{{ $record->type === 'income' ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $record->type === 'income' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                        {{ $record->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                                <td>{{ $record->title }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $record->category }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="showDetail({{ $record->id }})" class="btn btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button wire:click="edit({{ $record->id }})" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $record->id }})" class="btn btn-outline-danger" 
                                                onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada catatan keuangan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($records->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $records->links() }}
        </div>
        @endif
    </div>

    {{-- Chart --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Grafik Keuangan
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4 d-flex flex-wrap gap-2 align-items-center">
                <div class="btn-group btn-group-modern" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="updateChartType('line')">
                        <i class="fas fa-chart-line me-1"></i>Line
                    </button>
                </div>
                <div class="btn-group btn-group-modern ms-2" role="group">
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('7d')">7 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('30d')">30 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('all')">Semua</button>
                </div>
            </div>
            <div id="financial-chart" class="chart-container"></div>
        </div>
    </div>

    {{-- Form Modal Tambah --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showForm ? 'block' : 'none' }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showForm', false)"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-tag me-2 text-primary"></i>Jenis
                            </label>
                            <select id="add-type" wire:model.live="type" class="form-select form-control-modern">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-money-bill me-2 text-primary"></i>Jumlah
                            </label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text">Rp</span>
                                <input type="number" wire:model="amount" class="form-control" step="0.01" placeholder="0">
                            </div>
                            @error('amount') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-heading me-2 text-primary"></i>Judul
                            </label>
                            <input type="text" wire:model="title" class="form-control form-control-modern" placeholder="Masukkan judul transaksi">
                            @error('title') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi
                            </label>
                            <textarea wire:model="description" class="form-control form-control-modern" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-folder me-2 text-primary"></i>Kategori
                            </label>
                            <select id="add-category" wire:model="category" class="form-select form-control-modern">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-image me-2 text-primary"></i>Gambar
                            </label>
                            <input type="file" wire:model="image" class="form-control form-control-modern" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-2">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Transaksi
                            </label>
                            <input type="date" wire:model="transaction_date" class="form-control form-control-modern">
                            @error('transaction_date') <span class="text-danger small mt-1 d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 p-3">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showForm', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showEditModal ? 'block' : 'none' }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern border-0 shadow-lg">
                <div class="modal-header bg-gradient-warning text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-edit me-2"></i>Edit Catatan Keuangan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showEditModal', false)"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-tag me-2 text-warning"></i>Jenis
                            </label>
                            <select id="edit-type" wire:model="type" class="form-select form-control-modern">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-money-bill me-2 text-warning"></i>Jumlah
                            </label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text">Rp</span>
                                <input type="number" wire:model="amount" class="form-control" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-heading me-2 text-warning"></i>Judul
                            </label>
                            <input type="text" wire:model="title" class="form-control form-control-modern">
                            @error('title') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-align-left me-2 text-warning"></i>Deskripsi
                            </label>
                            <textarea wire:model="description" class="form-control form-control-modern" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-folder me-2 text-warning"></i>Kategori
                            </label>
                            <select id="edit-category" wire:model="category" class="form-select form-control-modern">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-image me-2 text-warning"></i>Gambar
                            </label>
                            <input type="file" wire:model="image" class="form-control form-control-modern" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary small mt-2">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-calendar me-2 text-warning"></i>Tanggal Transaksi
                            </label>
                            <input type="date" wire:model="transaction_date" class="form-control form-control-modern">
                            @error('transaction_date') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 p-3">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)">
                            <i class="fas fa-times me-1"></i>Tutup
                        </button>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showDetailModal ? 'block' : 'none' }}">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-modern border-0 shadow-lg">
                <div class="modal-header bg-gradient-info text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-eye me-2"></i>Detail Catatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showDetailModal', false)"></button>
                </div>
                <div class="modal-body p-4">
                    @if($selectedRecord)
                        <div class="detail-container">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-heading text-info me-2"></i>Judul
                                </div>
                                <div class="detail-value">{{ $selectedRecord->title }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-tag text-info me-2"></i>Jenis
                                </div>
                                <div class="detail-value">
                                    <span class="badge badge-modern bg-{{ $selectedRecord->type === 'income' ? 'success' : 'danger' }}">
                                        {{ $selectedRecord->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-money-bill text-info me-2"></i>Jumlah
                                </div>
                                <div class="detail-value fw-bold text-dark">Rp {{ number_format($selectedRecord->amount, 0, ',', '.') }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-folder text-info me-2"></i>Kategori
                                </div>
                                <div class="detail-value">
                                    <span class="badge bg-light text-dark">{{ $selectedRecord->category }}</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar text-info me-2"></i>Tanggal
                                </div>
                                <div class="detail-value">{{ $selectedRecord->transaction_date->format('d/m/Y') }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                                </div>
                                <div class="detail-value">{{ $selectedRecord->description ?: '-' }}</div>
                            </div>
                            @if($selectedRecord->image_path)
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-image text-info me-2"></i>Gambar
                                    </div>
                                    <div class="detail-value">
                                        <img src="{{ asset('storage/' . $selectedRecord->image_path) }}" alt="Gambar" class="img-thumbnail detail-image"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Tidak ada data untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light border-0 p-3">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDetailModal', false)">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    let chart;
    let currentPeriod = 'all';
    let currentType = 'line';
        
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

        function aggregateByDate(points) {
            const map = {};
            points.forEach(p => {
                const d = p.x;
                if (!map[d]) map[d] = 0;
                map[d] += Number(p.y || 0);
            });
            return Object.keys(map).sort().map(d => ({ x: d, y: map[d] }));
        }

        function recomputeAggregatedOriginal() {
            const originalData = readOriginalDataFromDom();
            return {
                income: aggregateByDate(originalData.income || []),
                expense: aggregateByDate(originalData.expense || [])
            };
        }

        let aggregatedOriginal = recomputeAggregatedOriginal();

        const categories = @json($categories);

        function populateCategoryOptions(selectEl, type) {
            if (!selectEl) return;
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

        document.addEventListener('livewire:update', () => {
            const addType = document.getElementById('add-type');
            const addCategory = document.getElementById('add-category');
            const editType = document.getElementById('edit-type');
            const editCategory = document.getElementById('edit-category');
            if (addType && addCategory) populateCategoryOptions(addCategory, addType.value || 'expense');
            if (editType && editCategory) populateCategoryOptions(editCategory, editType.value || 'expense');
        });

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

        function updateChart(data) {
            const dateSet = new Set();
            data.income.forEach(p => dateSet.add(p.x));
            data.expense.forEach(p => dateSet.add(p.x));
            const dates = Array.from(dateSet).sort();

            const incomeMap = Object.fromEntries(data.income.map(p => [p.x, p.y]));
            const expenseMap = Object.fromEntries(data.expense.map(p => [p.x, p.y]));

            const incomePoints = dates.map(d => ({ x: d, y: incomeMap[d] || 0 }));
            const expensePoints = dates.map(d => ({ x: d, y: expenseMap[d] || 0 }));

            function getChartFilterValue() {
                const el = document.getElementById('chart-filter');
                return el ? el.value : '';
            }

            const chartFilter = getChartFilterValue();

            const series = [];
            const seriesColors = [];
            if (!chartFilter || chartFilter === 'income') {
                series.push({ name: 'Pemasukan', data: incomePoints });
                seriesColors.push('#28a745');
            }
            if (!chartFilter || chartFilter === 'expense') {
                series.push({ name: 'Pengeluaran', data: expensePoints });
                seriesColors.push('#dc3545');
            }

            try { console.debug('updateChart', { chartFilter, datesLength: dates.length, incomeLen: data.income.length, expenseLen: data.expense.length, seriesLen: series.length }); } catch(e){}

            const chartContainer = document.querySelector('#financial-chart');
            if (!dates || dates.length === 0) {
                if (chartContainer) {
                    chartContainer.innerHTML = '<div class="text-center py-5 text-muted"><i class="fas fa-chart-line fa-3x mb-3 opacity-25"></i><p class="mb-0">Tidak ada data grafik untuk periode/jenis yang dipilih.</p></div>';
                }
                return;
            }

            const options = {
                chart: {
                    type: currentType,
                    height: 350,
                    zoom: { enabled: false },
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                series: series,
                dataLabels: { enabled: false },
                xaxis: {
                    type: 'datetime',
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
                },
                grid: {
                    borderColor: '#e7e7e7',
                    strokeDashArray: 4
                }
            };

            if (chart) {
                chart.destroy();
            }
            
            chart = new ApexCharts(document.querySelector("#financial-chart"), options);
            chart.render();
        }

        function updateChartType(type) {
            currentType = type;
            const filteredData = filterDataByPeriod(currentPeriod);
            updateChart(filteredData);
            
            document.querySelectorAll('[onclick^="updateChartType"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(type)) {
                    btn.classList.add('active');
                }
            });
        }

        function updateChartPeriod(period) {
            currentPeriod = period;
            const filteredData = filterDataByPeriod(period);
            updateChart(filteredData);
            
            document.querySelectorAll('[onclick^="updateChartPeriod"]').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('onclick').includes(period)) {
                    btn.classList.add('active');
                }
            });
        }

        updateChart(aggregatedOriginal);

        function attachFilterListener() {
            const filterEl = document.getElementById('chart-filter');
            if (!filterEl) return;
            const newEl = filterEl.cloneNode(true);
            filterEl.parentNode.replaceChild(newEl, filterEl);
            newEl.addEventListener('change', () => {
                const filteredData = filterDataByPeriod(currentPeriod);
                updateChart(filteredData);
            });
        }

        document.addEventListener('DOMContentLoaded', () => attachFilterListener());

        document.addEventListener('livewire:update', () => {
            attachFilterListener();
            aggregatedOriginal = recomputeAggregatedOriginal();
            const filterEl = document.getElementById('chart-filter');
            if (filterEl) {
                const filteredData = filterDataByPeriod(currentPeriod);
                updateChart(filteredData);
            } else {
                updateChart(aggregatedOriginal);
            }
        });

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

        document.addEventListener('DOMContentLoaded', () => setActiveButtons());
        document.addEventListener('livewire:update', () => setActiveButtons());

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
        /* Modern Design System */
        :root {
            --primary-color: #0d6efd;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --box-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Global Improvements */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Statistics Cards */
        .stat-card {
            border-radius: var(--border-radius);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.shadow-hover {
            box-shadow: var(--box-shadow);
        }

        .stat-card:hover.shadow-hover {
            box-shadow: var(--box-shadow-lg);
        }

        .stat-card .card-body {
            position: relative;
            z-index: 2;
        }

        .stat-icon {
            font-size: 3rem;
            opacity: 0.9;
        }

        .stat-label {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.75rem;
        }

        .card-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover .card-shine {
            left: 100%;
        }

        /* Modern Cards */
        .card {
            border-radius: var(--border-radius);
            border: none;
            transition: var(--transition);
        }

        .card-header {
            background: transparent;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.125rem;
            margin: 0;
        }

        /* Modern Table */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            color: #495057;
        }

        .table-modern thead th.sortable {
            cursor: pointer;
            user-select: none;
            transition: var(--transition);
        }

        .table-modern thead th.sortable:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }

        .table-modern tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .table-modern tbody tr:hover {
            background: rgba(13, 110, 253, 0.03);
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Modern Badges */
        .badge-modern {
            padding: 0.5rem 0.875rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Modern Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            transition: var(--transition);
            border: none;
        }

        .btn-action {
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--box-shadow);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        }

        .btn-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
        }

        .btn-group-modern .btn {
            border-radius: 8px;
            margin: 0 2px;
        }

        .btn-outline-primary.active,
        .btn-outline-secondary.active {
            box-shadow: inset 0 0 0 2px currentColor;
        }

        /* Modern Input Groups */
        .input-group-modern {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .input-group-modern .input-group-text {
            border: 1px solid #dee2e6;
            background: white;
        }

        .input-group-modern .form-control,
        .input-group-modern .form-select {
            border: 1px solid #dee2e6;
        }

        .input-group-modern .form-control:focus,
        .input-group-modern .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        /* Modern Form Controls */
        .form-control-modern,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control-modern:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        /* Modern Modals */
        .modal {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-modern .modal-content {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .modal-modern .modal-header {
            padding: 1.5rem;
        }

        .modal-modern .modal-body {
            background: #fafbfc;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #00bcd4 100%);
        }

        /* Detail Container */
        .detail-container {
            display: grid;
            gap: 1.25rem;
        }

        .detail-item {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
        }

        .detail-value {
            color: #212529;
            display: flex;
            align-items: center;
        }

        .detail-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            max-height: 300px;
            object-fit: cover;
        }

        /* Chart Container */
        .chart-container {
            padding: 1rem;
            background: white;
            border-radius: 8px;
        }

        /* Pagination */
        .pagination {
            margin: 0;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .detail-item {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .stat-icon {
                font-size: 2.5rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card, .stat-card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Loading States */
        [wire\:loading] {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Empty State */
        .text-muted i.fa-inbox,
        .text-muted i.fa-chart-line {
            display: block;
            margin: 0 auto 1rem;
        }
    </style>
    @endpush

    <div id="swal-data" style="display:none" data-swal='@json($swal)'></div>

    <div id="chart-data" style="display:none"
        data-income='@json(($chartRecords->where('type', 'income')->map(function($r){ return ['x' => $r->transaction_date->format('Y-m-d'), 'y' => (float) $r->amount]; })->values()) ?? [])'
        data-expense='@json(($chartRecords->where('type', 'expense')->map(function($r){ return ['x' => $r->transaction_date->format('Y-m-d'), 'y' => (float) $r->amount]; })->values()) ?? [])'>
    </div>

    <script>
        function readSwalDataAndShow() {
            const el = document.getElementById('swal-data');
            if (!el) return;
            let raw = el.getAttribute('data-swal');
            if (!raw || raw === 'null') return;
            try {
                const payload = JSON.parse(raw);
                if (payload && payload.title) {
                    Swal.fire({
                        icon: payload.icon || 'info',
                        title: payload.title,
                        text: payload.text || ''
                    });
                    el.setAttribute('data-swal', 'null');
                }
            } catch (e) {
            }
        }

        document.addEventListener('DOMContentLoaded', () => readSwalDataAndShow());
        document.addEventListener('livewire:update', () => readSwalDataAndShow());
    </script>

</div>