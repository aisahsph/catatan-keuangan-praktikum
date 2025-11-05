<div class="container py-4">
    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6"><i class="fas fa-wallet"></i></div>
                        <div>
                            <h6 class="card-title mb-1">Total Pemasukan</h6>
                            <h4 class="mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6"><i class="fas fa-credit-card"></i></div>
                        <div>
                            <h6 class="card-title mb-1">Total Pengeluaran</h6>
                            <h4 class="mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6"><i class="fas fa-coins"></i></div>
                        <div>
                            <h6 class="card-title mb-1">Sisa Uang</h6>
                            <h4 class="mb-0">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    {{-- Filter dan Pencarian --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <button type="button" class="btn btn-primary shadow-sm w-100" wire:click="$set('showForm', true)">
                <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan
            </button>
        </div>
        <div class="col-md-4">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-filter text-muted"></i>
                </span>
                <select id="chart-filter" wire:model.live="filter" class="form-select border-start-0">
                    <option value="">Semua Jenis</option>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" 
                    wire:model.live="search" 
                    class="form-control border-start-0" 
                    placeholder="Cari catatan...">
            </div>
        </div>
    </div>

    {{-- Chart: placed below the table as requested --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Grafik Keuangan</h5>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex align-items-center">
                <div class="btn-group" role="group" aria-label="Chart type">
                    <button type="button" class="btn btn-outline-primary active" onclick="updateChartType('line')">Line</button>
                </div>
                <div class="btn-group ms-2" role="group" aria-label="Time period">
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('7d')">7 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('30d')">30 Hari</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="updateChartPeriod('all')">Semua</button>
                </div>
            </div>
            <div id="financial-chart"></div>
        </div>
    </div>

    {{-- Tabel Catatan Keuangan --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr class="table-light">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        {{-- FIX: Nomor Urut Akurat dan Berurutan di semua halaman --}}
                        <td>{{ ($records->firstItem() + $loop->index) }}</td>
                        <td>{{ $record->transaction_date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $record->type === 'income' ? 'success' : 'danger' }}">
                                {{ $record->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                        <td>{{ $record->title }}</td>
                        <td>{{ $record->category }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button wire:click="showDetail({{ $record->id }})" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="edit({{ $record->id }})" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $record->id }})" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada catatan keuangan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- PAGINASI: Menampilkan tautan navigasi di bawah tabel --}}
        {{ $records->links() }}
    </div>

    {{-- Chart: placed below the table as requested --}}

    {{-- Form Modal Tambah --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showForm ? 'block' : 'none' }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close" wire:click="$set('showForm', false)"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-tag me-2"></i>Jenis</label>
                            <select id="add-type" wire:model.live="type" class="form-select border-2">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-money-bill me-2"></i>Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" wire:model="amount" class="form-control border-2" step="0.01">
                            </div>
                            @error('amount') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-heading me-2"></i>Judul</label>
                            <input type="text" wire:model="title" class="form-control border-2">
                            @error('title') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                            <textarea wire:model="description" class="form-control border-2" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-folder me-2"></i>Kategori</label>
                            <select id="add-category" wire:model="category" class="form-select border-2">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-image me-2"></i>Gambar</label>
                            <input type="file" wire:model="image" class="form-control border-2" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary mt-1">
                                <i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...
                            </div>
                            @error('image') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-calendar me-2"></i>Tanggal Transaksi</label>
                            <input type="date" wire:model="transaction_date" class="form-control border-2">
                            @error('transaction_date') <span class="text-danger mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Catatan Keuangan</h5>
                    <button type="button" class="btn-close" wire:click="$set('showEditModal', false)"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select id="edit-type" wire:model="type" class="form-select">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" wire:model="amount" class="form-control" step="0.01">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" wire:model="title" class="form-control">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model="description" class="form-control" rows="3" placeholder="Tambahkan keterangan atau catatan (opsional)"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select id="edit-category" wire:model="category" class="form-select">
                                <option value="">Pilih kategori</option>
                                @foreach(($categories[$type] ?? []) as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" wire:model="image" class="form-control" accept="image/*">
                            <div wire:loading wire:target="image" class="text-primary mt-1 small">
                                Mengunggah...
                            </div>
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Transaksi</label>
                            <input type="date" wire:model="transaction_date" class="form-control">
                            @error('transaction_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)">Tutup</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal" tabindex="-1" role="dialog" style="display: {{ $showDetailModal ? 'block' : 'none' }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Catatan</h5>
                    <button type="button" class="btn-close" wire:click="$set('showDetailModal', false)"></button>
                </div>
                <div class="modal-body">
                    @if($selectedRecord)
                        <dl class="row">
                            <dt class="col-sm-3">Judul</dt>
                            <dd class="col-sm-9">{{ $selectedRecord->title }}</dd>

                            <dt class="col-sm-3">Jenis</dt>
                            <dd class="col-sm-9">{{ $selectedRecord->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</dd>

                            <dt class="col-sm-3">Jumlah</dt>
                            <dd class="col-sm-9">Rp {{ number_format($selectedRecord->amount, 0, ',', '.') }}</dd>

                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ $selectedRecord->category }}</dd>

                            <dt class="col-sm-3">Tanggal</dt>
                            <dd class="col-sm-9">{{ $selectedRecord->transaction_date->format('d/m/Y') }}</dd>

                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9">{{ $selectedRecord->description }}</dd>

                            @if($selectedRecord->image_path)
                                <dt class="col-sm-3">Gambar</dt>
                                <dd class="col-sm-9"><img src="{{ asset('storage/' . $selectedRecord->image_path) }}" alt="Gambar" class="img-fluid"/></dd>
                            @endif
                        </dl>
                    @else
                        <p>Tidak ada data untuk ditampilkan.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showDetailModal', false)">Tutup</button>
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
                seriesColors.push('#28a745');
            }
            if (!chartFilter || chartFilter === 'expense') {
                series.push({ name: 'Pengeluaran', data: expensePoints });
                seriesColors.push('#dc3545');
            }

                // Debugging info (will appear in browser console)
                try { console.debug('updateChart', { chartFilter, datesLength: dates.length, incomeLen: data.income.length, expenseLen: data.expense.length, seriesLen: series.length }); } catch(e){}

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
            const filteredData = filterDataByPeriod(period);
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
/* Tiny aesthetic improvements */
.card-title { font-weight: 600; }
.table thead tr.table-light th { border-top: none; }
.table-hover tbody tr:hover { background: rgba(0,0,0,0.03); }
.btn.active { box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08); }
.btn-outline-primary.active { background-color: #0d6efd; color: #fff; border-color: #0d6efd; }
.btn-outline-secondary.active { background-color: #6c757d; color: #fff; border-color: #6c757d; }
.img-fluid { max-height: 200px; }
.container .card { border: none; }
.stat-card .display-6 { font-size: 1.6rem; }
/* More aesthetic polish */
.card { border-radius: 12px; }
.card .card-body { background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(250,250,250,0.9)); }
.card-header { background: transparent; border-bottom: 0; }
.stat-card .card-body { display:flex; gap: 1rem; align-items:center; }
.table { background: #fff; }
.table thead th { background: linear-gradient(90deg, #f8f9fa, #eef2f6); }
.btn-group .btn { transition: all .15s ease; }
.chart-container { padding: 1rem; }

/* make the net series stand out with dashed markers when negative */
.apexcharts-series .apexcharts-series-2 .apexcharts-marker { stroke-dasharray: 3; }

/* Brighten stat cards: override gradient for colored stat cards to keep colors vivid */
.card.bg-success .card-body, .card.bg-danger .card-body, .card.bg-primary .card-body {
    background: transparent !important;
}
.card.bg-success { box-shadow: 0 6px 18px rgba(40,167,69,0.12); }
.card.bg-danger { box-shadow: 0 6px 18px rgba(220,53,69,0.12); }
.card.bg-primary { box-shadow: 0 6px 18px rgba(13,110,253,0.12); }
.card.bg-success .display-6, .card.bg-danger .display-6, .card.bg-primary .display-6 { color: #fff; }
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
        if (!raw || raw === 'null') return;
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

</div>