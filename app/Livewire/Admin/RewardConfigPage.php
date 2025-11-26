<?php

namespace App\Livewire\Admin;

use App\Models\Reward; 
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Throwable; 

class RewardConfigPage extends Component
{
    use WithFileUploads;
    
    // ==================================
    // 1. PROPERTI UNTUK DATA DAN MODAL
    // ==================================
    public $rewards; // <-- HARUS ADA: Properti untuk menampung data tabel
    public $is_modal_open = false; 
    
    // Properti Form
    public $reward_id; // Untuk Edit/Update
    public $gambar_lama; // Untuk Edit/Update
    public $nama_hadiah;
    public $kategori_id;
    public $stok;
    public $gambar_hadiah;
    
    // Listener untuk me-refresh data (dipanggil dari saveHadiah)
    protected $listeners = ['rewardAdded' => 'loadRewards']; 

    #[Layout('components.layouts.admin')]

    // ==================================
    // 2. LIFECYCLE HOOKS (PEMUATAN DATA)
    // ==================================

    // Metode mount() akan dijalankan pertama kali untuk memuat data
    public function mount()
    {
        $this->loadRewards();
    }
    
    // Metode untuk mengambil data dari database
    public function loadRewards()
    {
        // Mengambil semua data hadiah dan menyimpannya di properti $rewards
        $this->rewards = Reward::all();
    }
    
    // ==================================
    // 3. LOGIKA MODAL DAN FORM
    // ==================================

    public function openModal()
    {
        $this->resetForm();
        $this->is_modal_open = true;
    }

    public function closeModal()
    {
        $this->is_modal_open = false;
        $this->resetErrorBag();
    }

    protected function resetForm()
    {
        $this->reset(['reward_id', 'gambar_lama', 'nama_hadiah', 'kategori_id', 'stok', 'gambar_hadiah']);
        $this->resetErrorBag();
    }

    public function saveHadiah()
    {
        try {
             $this->validate([
                'nama_hadiah'   => 'required|string|max:255',
                'stok'          => 'required|integer|min:1',
                'kategori_id'   => 'required|integer|exists:reward_categories,id', 
                'gambar_hadiah' => 'nullable|image|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; 
        }

        $path = $this->gambar_lama; 

        try {
            // ... (Logika upload file dan UPDATE/CREATE) ...

            // Tentukan apakah ini mode CREATE atau UPDATE
            $data = [
                'nama_hadiah'        => $this->nama_hadiah,
                'reward_category_id' => $this->kategori_id,
                'stok'               => $this->stok,
                'gambar'             => $path,
            ];

            if ($this->reward_id) {
                // UPDATE
                Reward::find($this->reward_id)->update($data);
                $message = 'Hadiah berhasil diperbarui.';
            } else {
                // CREATE
                $data['status_hadiah'] = 'Aktif'; 
                Reward::create($data);
                $message = 'Hadiah berhasil ditambahkan.';
            }

            // PENTING: Panggil metode loadRewards untuk update tampilan
            $this->loadRewards(); 
            
            $this->resetForm();
            $this->closeModal();
            $this->dispatch('rewardAdded'); 
            session()->flash('success_message', $message);
            
        } catch (Throwable $e) {
            report($e);
            session()->flash('error_message', 'Gagal menyimpan data (DB/Server Error).');
        }
    }
    
    // Metode pendengar (Listener) dipanggil saat event 'rewardAdded' diterima
    public function rewardAdded($rewardId = null)
    {
        // Memastikan data di-refresh saat event diterima
        $this->loadRewards(); 
    }

    // ==================================
    // 4. RENDER VIEW
    // ==================================
    public function render()
    {
        return view('livewire.admin.reward-config-page');
    }
}