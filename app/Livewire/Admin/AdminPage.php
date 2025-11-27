<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPage extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Daftar Admin')]

    protected $paginationTheme = 'bootstrap';

    // Properties Form
    public $nama;
    public $username;
    public $password;

    // Properties Helper
    public $search = '';
    public $deleteId;

    // === 1. FUNCTION CREATE ===
    public function store()
    {
        $this->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username', // Cek unik di tabel users
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama'     => $this->nama,
            'username' => $this->username,
            'password' => Hash::make($this->password), // Wajib di-Hash!
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Admin baru berhasil ditambahkan.');
    }

    // === 2. FUNCTION DELETE ===
    public function setDeleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        // 1. Cek Self-Delete (Akun sendiri)
        if ($this->deleteId == Auth::user()->id) {
            $this->dispatch('close-modal');
            session()->flash('error', 'Gagal! Anda tidak boleh menghapus akun sendiri.');
            return;
        }

        // 2. Cek Apakah Admin Tersebut Sedang ONLINE?
        // Logika: Cek tabel sessions, cari user_id yang cocok DAN aktivitas terakhir < 5 menit lalu
        $isOnline = DB::table('sessions')
            ->where('user_id', $this->deleteId)
            ->where('last_activity', '>=', now()->subMinutes(5)->getTimestamp())
            ->exists();

        if ($isOnline) {
            $this->dispatch('close-modal');
            session()->flash('error', 'Gagal! Admin ini sedang Online/Login. Tunggu dia logout dulu.');
            return;
        }

        // 3. Eksekusi Hapus (Jika lolos pengecekan)
        $admin = User::find($this->deleteId);
        if ($admin) {
            $admin->delete();
            session()->flash('message', 'Admin berhasil dihapus.');
        }

        $this->dispatch('close-modal');
    }

    public function resetForm()
    {
        $this->reset(['nama', 'username', 'password', 'deleteId']);
        $this->resetValidation();
    }

    public function render()
    {
        $admins = User::query()
            ->when($this->search, function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.admin-page', [
            'admins' => $admins
        ]);
    }
}
