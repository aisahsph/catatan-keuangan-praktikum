<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\FinancialRecord;
use Illuminate\Support\Facades\Storage;

/**
 * ╔═══════════════════════════════════════════════════════════════════════╗
 * ║                                                                       ║
 * ║        💎 FINANCIAL RECORDS LIVEWIRE COMPONENT 💎                     ║
 * ║                                                                       ║
 * ║     Real-time financial management with elegant interactions         ║
 * ║     Built with Livewire for seamless user experience                 ║
 * ║                                                                       ║
 * ╚═══════════════════════════════════════════════════════════════════════╝
 */

class FinancialRecordsLivewire extends Component
{
    // ┌─────────────────────────────────────────────────────────────────┐
    // │  🎨 Traits & Configuration                                      │
    // └─────────────────────────────────────────────────────────────────┘
    
    // FIX 1: Memastikan styling paginasi menggunakan Bootstrap
    protected $paginationTheme = 'bootstrap'; 
    use WithPagination, WithFileUploads;

    // ┌─────────────────────────────────────────────────────────────────┐
    // │  📊 Component State Properties                                  │
    // └─────────────────────────────────────────────────────────────────┘
    
    public $showForm = false;          // 📝 Toggle form visibility
    public $showEditModal = false;     // ✏️ Edit modal state
    public $showDetailModal = false;   // 👁️ Detail view state
    public $search = '';               // 🔍 Search query
    public $filter = '';               // 🎯 Filter by type
    
    // FIX 2: Default sorting ke Tanggal Terbaru (desc)
    public $sortField = 'transaction_date';  // 📅 Default sort field
    public $sortDirection = 'desc';          // ⬇️ Data terbaru akan muncul di atas
    
    public $selectedRecord = null;     // 🎯 Currently selected record
    public $swal = null;               // 🔔 SweetAlert notifications
    
    // ┌─────────────────────────────────────────────────────────────────┐
    // │  📝 Form Input Fields                                           │
    // └─────────────────────────────────────────────────────────────────┘
    
    public $recordId;            // 🆔 Record identifier
    public $type = 'expense';    // 💸 Transaction type
    public $amount;              // 💰 Amount value
    public $title;               // 📌 Transaction title
    public $description;         // 📄 Detailed description
    public $category;            // 🏷️ Category tag
    public $image;               // 🖼️ Receipt image
    public $transaction_date;    // 📆 Transaction date

    // ┌─────────────────────────────────────────────────────────────────┐
    // │  🏷️ Available Categories                                        │
    // └─────────────────────────────────────────────────────────────────┘
    
    public $categories = [
        'income' => [
            'Gaji',          // 💼 Salary
            'Bonus',         // 🎁 Bonus
            'Hadiah',        // 🎉 Gift
            'Investasi',     // 📈 Investment
            'Penjualan',     // 🛒 Sales
            'Lainnya'        // ➕ Others
        ],
        'expense' => [
            'Makanan & Minuman',  // 🍔 Food & Beverages
            'Transportasi',       // 🚗 Transportation
            'Belanja',            // 🛍️ Shopping
            'Pendidikan',         // 📚 Education
            'Hiburan',            // 🎮 Entertainment
            'Kesehatan',          // 🏥 Healthcare
            'Tagihan',            // 💳 Bills
            'Lainnya'             // ➕ Others
        ]
    ];
    
    // ┌─────────────────────────────────────────────────────────────────┐
    // │  ✅ Validation Rules                                            │
    // └─────────────────────────────────────────────────────────────────┘
    
    protected $rules = [
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:0',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:255',
        'image' => 'nullable|image',
        'transaction_date' => 'required|date'
    ];

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  🔄 Lifecycle Hooks
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    // FIX 3: Mereset halaman saat ada perubahan filter atau pencarian
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filter'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
    }

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  👁️ View & Display Methods
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function showDetail($id)
    {
        $this->selectedRecord = FinancialRecord::find($id);
        $this->showDetailModal = true;
    }
    
    public function render()
    {
        $query = FinancialRecord::where('user_id', auth()->id())
            // Search should be grouped so ORs don't bypass other WHERE clauses like the type filter
            ->when($this->search, function($q) {
                $search = $this->search;
                $q->where(function($q2) use ($search) {
                    $q2->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when($this->filter, function($q) {
                $q->where('type', $this->filter);
            })
            // Pengurutan menggunakan properti sortField dan sortDirection (default: transaction_date DESC)
            ->orderBy($this->sortField, $this->sortDirection);

        // Paginasi 20 data per halaman
        $records = $query->paginate(20);

        // Also pass all records (no pagination) for charting so the chart shows data from previous years
        $chartRecords = FinancialRecord::where('user_id', auth()->id())
            ->orderBy('transaction_date', 'asc')
            ->get();

        return view('livewire.financial-records-livewire', [
            'records' => $records,
            'chartRecords' => $chartRecords,
            'totalIncome' => FinancialRecord::where('user_id', auth()->id())
                ->where('type', 'income')
                ->sum('amount'),
            'totalExpense' => FinancialRecord::where('user_id', auth()->id())
                ->where('type', 'expense')
                ->sum('amount')
        ]);
    }

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  💾 CRUD Operations
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    // ─── Create New Record ────────────────────────────────────────────
    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('records', 'public');
        }

        auth()->user()->financialRecords()->create([
            'type' => $this->type,
            'amount' => $this->amount,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'image_path' => $imagePath,
            'transaction_date' => $this->transaction_date
        ]);

        $this->reset(['showForm', 'type', 'amount', 'title', 'description', 'category', 'image', 'transaction_date']);
        $this->swal = [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Catatan keuangan berhasil disimpan.'
        ];
    }

    // ─── Edit Existing Record ─────────────────────────────────────────
    public function edit($id)
    {
        $record = FinancialRecord::findOrFail($id);
        $this->recordId = $id;
        $this->type = $record->type;
        $this->amount = $record->amount;
        $this->title = $record->title;
        $this->description = $record->description;
        $this->category = $record->category;
        $this->transaction_date = $record->transaction_date->format('Y-m-d');
        $this->showEditModal = true;
    }

    // ─── Update Record ────────────────────────────────────────────────
    public function update()
    {
        $this->validate();

        $record = FinancialRecord::findOrFail($this->recordId);
        
        $imagePath = $record->image_path;
        if ($this->image) {
            if ($record->image_path) {
                Storage::disk('public')->delete($record->image_path);
            }
            $imagePath = $this->image->store('records', 'public');
        }

        $record->update([
            'type' => $this->type,
            'amount' => $this->amount,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'image_path' => $imagePath,
            'transaction_date' => $this->transaction_date
        ]);

        $this->reset(['showEditModal', 'recordId', 'type', 'amount', 'title', 'description', 'category', 'image', 'transaction_date']);
        $this->swal = [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Catatan keuangan berhasil diperbarui.'
        ];
    }

    // ─── Delete Record ────────────────────────────────────────────────
    public function delete($id)
    {
        $record = FinancialRecord::findOrFail($id);
        if ($record->image_path) {
            Storage::disk('public')->delete($record->image_path);
        }
        $record->delete();

        $this->swal = [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Catatan keuangan berhasil dihapus.'
        ];
    }

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  🔀 Sorting & Filtering
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function sortBy($field)
    {
        // FIX 4: Reset halaman saat sorting berubah agar nomor urut konsisten
        $this->resetPage(); 
        
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            // Ketika field berubah, default sorting diset ke 'desc' (terbaru) untuk tanggal, dan 'asc' untuk field lain
            $this->sortDirection = ($field === 'transaction_date') ? 'desc' : 'asc';
        }
    }
}

// ═══════════════════════════════════════════════════════════════════════
//  ✨ Powered by Livewire - Real-time reactivity at its finest
//  💜 Made with care for seamless financial management
// ═══════════════════════════════════════════════════════════════════════