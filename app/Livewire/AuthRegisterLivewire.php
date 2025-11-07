<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AuthRegisterLivewire extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation; // <-- DITAMBAHKAN untuk menampung konfirmasi sandi

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            
            // MODIFIKASI: Menggunakan aturan 'confirmed'
            // 'password' akan dicek kesamaannya dengan $password_confirmation
            'password' => 'required|string|min:8|confirmed', 
            // Catatan: Anda tidak perlu mendefinisikan aturan untuk 'password_confirmation',
            // karena Laravel akan mencarinya secara otomatis.
        ]);

        // Daftarkan user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Reset data
        $this->reset(['name', 'email', 'password', 'password_confirmation']); // Reset juga konfirmasi sandi

        // Redirect ke halaman login
        return redirect()->route('auth.login');
    }

    public function render()
    {
        return view('livewire.auth-register-livewire');
    }
}