<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah nama tabel dari 'todos' menjadi 'catatankeuangan'
        Schema::create('catatankeuangan', function (Blueprint $table) {
            $table->id();
            
            // 2. Kolom Relasi (Wajib untuk Proyek Praktikum)
            // Menggunakan foreignId() adalah cara modern dan lebih ringkas di Laravel
            $table->foreignId('user_id')
                  ->constrained('users') // Mengacu ke tabel 'users'
                  ->onDelete('cascade'); // Jika user dihapus, catatan ikut terhapus

            // 3. Kolom Tipe Transaksi: Pemasukan atau Pengeluaran
            $table->enum('type', ['income', 'expense']); 
            
            // 4. Kolom Deskripsi Transaksi (menggantikan 'title' dan 'description' ToDo)
            $table->string('description');
            
            // 5. Kolom Nominal Uang
            // bigInteger cocok untuk menyimpan nilai uang (rupiah)
            $table->bigInteger('amount'); 
            
            // 6. Kolom Tanggal Transaksi
            $table->date('date');
            
            // Kolom timestamps (created_at dan updated_at)
            $table->timestamps();
            
            // Hapus baris foreign key yang lama (tidak diperlukan jika menggunakan foreignId()->constrained())
            // Hapus: $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ubah nama tabel yang dihapus menjadi 'catatankeuangan'
        Schema::dropIfExists('catatankeuangan');
    }
};