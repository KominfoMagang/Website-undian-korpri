<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class LoginPage extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Login Admin')]

    public $username;
    public $password;
    public $showPassword = false;

    public function login()
    {
        // 1. Validasi Input
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Coba Login dengan Guard 'web' (Tabel Users)
        if (Auth::guard('web')->attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();
            return $this->redirectRoute('admin.dashboard', navigate: true);
        }

        // 3. Jika Gagal
        $this->addError('username', 'Username atau password salah.');
    }

    // Fungsi Toggle Show/Hide Password
    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
