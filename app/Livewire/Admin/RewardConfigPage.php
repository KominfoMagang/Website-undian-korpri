<?php

namespace App\Livewire\Admin;

use App\Models\Reward; 
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Throwable; 

#[Title('Kategori & Hadiah')] 

class RewardConfigPage extends Component
{
    use WithFileUploads;
    
    // ==================================
    // 1. PROPERTI UNTUK DATA DAN MODAL
    // ==================================
    public $rewards; 
    public $is_modal_open = false; 
    
    // Properti Form
    public $reward_id;   // Kunci untuk mode Edit/Update
    public $gambar_lama; // Kunci untuk menyimpan path gambar lama
    
    public $nama_hadiah;
    public $kategori_id;
    public $stok;
    public $gambar_hadiah; // File object yang diupload
    
    protected $listeners = ['rewardAdded' => 'loadRewards']; 

    #[Layout('components.layouts.admin')]

    // Metode mount() dan loadRewards() di sini
    public function mount()
    {
        $this->loadRewards();
    }
    
    public function loadRewards()
    {
        $this->rewards = Reward::all();
    }
    
    // open modal
    public function openModal()
    {
        $this->resetForm();
        $this->is_modal_open = true;
    }

    // close modal
    public function closeModal()
    {
        $this->is_modal_open = false;
        $this->resetErrorBag();
    }

    protected function resetForm()
    {
        // PENTING: RESET SEMUA PROPERTI FORM KE KONDISI KOSONG/DEFAULT
        $this->reset(['reward_id', 'gambar_lama', 'nama_hadiah', 'kategori_id', 'stok', 'gambar_hadiah']);
        $this->resetErrorBag();
    }
    
    // LOGIKA EDIT (Disertakan di sini untuk kelengkapan)
    public function editReward($id)
    {
        $reward = Reward::findOrFail($id);
        
        $this->reward_id = $reward->id;
        $this->nama_hadiah = $reward->nama_hadiah;
        $this->kategori_id = $reward->reward_category_id;
        $this->stok = $reward->stok;
        $this->gambar_lama = $reward->gambar; 
        
        $this->is_modal_open = true;
    }


    // ==================================
    // 5. LOGIKA SIMPAN/UPDATE
    // ==================================
    public function saveHadiah()
    {
        // 1. Validasi Input
        try {
             $this->validate([
                'nama_hadiah'   => 'required|string|max:255',
                // FIX: Ubah min:1 menjadi min:0 agar stok 0 diizinkan
                'stok'          => 'required|integer|min:0', 
                'kategori_id'   => 'required|integer|exists:reward_categories,id', 
                'gambar_hadiah' => 'nullable|image|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; 
        }

        $path = $this->gambar_lama; 
        
        try {
            // 2. Handle Upload File BARU
            if ($this->gambar_hadiah) {
                if ($this->gambar_lama) {
                    \Storage::disk('public')->delete($this->gambar_lama);
                }
                $filename = Str::slug($this->nama_hadiah) . '-' . time() . '.' . $this->gambar_hadiah->getClientOriginalExtension();
                $path = $this->gambar_hadiah->storeAs('hadiah', $filename, 'public');
            }

            $new_status = ($this->stok == 0) ? 'Tidak aktif' : 'Aktif';

            $data = [
                'nama_hadiah'        => $this->nama_hadiah,
                'reward_category_id' => $this->kategori_id,
                'stok'               => $this->stok,
                'gambar'             => $path,
                'status_hadiah'      => $new_status, // Terapkan status baru
            ];

            // 4. EKSEKUSI: CREATE atau UPDATE
            if ($this->reward_id) {
                // --- UPDATE MODE ---
                Reward::find($this->reward_id)->update($data);
                $message = 'Hadiah berhasil diperbarui.';
            } else {
                // --- CREATE MODE ---
                // Status sudah diset di $data di atas
                Reward::create($data);
                $message = 'Hadiah berhasil ditambahkan.';
            }
            
            // 5. Refresh tampilan dan tutup
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
    
    // ... (metode deleteReward, rewardAdded, dan render) ...
    
    public function deleteReward($id)
    {
        try {
            $reward = Reward::findOrFail($id);
            if ($reward->gambar) {
                \Storage::disk('public')->delete($reward->gambar);
            }
            $reward->delete();
            $this->loadRewards(); 
            session()->flash('success_message', 'Hadiah berhasil dihapus.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error_message', 'Gagal menghapus hadiah.');
        }
    }

    public function rewardAdded($rewardId = null)
    {
        $this->loadRewards(); 
    }

    public function render()
    {
        return view('livewire.admin.reward-config-page');
    }
}