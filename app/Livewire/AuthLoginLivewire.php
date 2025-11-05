<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuthLoginLivewire extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string',
        ]);

        // Periksa apakah pengguna berhasil login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Jika login berhasil
            session()->regenerate();
            return redirect()->route('app.home');
        }

        // Jika login gagal
        $this->addError('email', 'Email atau kata sandi salah.');
    }

    public function render()
    {
        return view('livewire.auth-login-livewire');
    }
}