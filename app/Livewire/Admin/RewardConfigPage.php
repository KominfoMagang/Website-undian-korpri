<?php

namespace App\Livewire\Admin;

use App\Models\Reward;
use App\Models\RewardCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Kategori & Hadiah')]

class RewardConfigPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Layout('components.layouts.admin')]

    protected $paginationTheme = 'bootstrap';

    public $nama_kategori;
    public $nama_hadiah;
    public $reward_category_id;
    public $stok;
    public $status_hadiah = 'Aktif';
    public $gambar;

    // === HELPER PROPERTIES ===
    public $oldGambar;
    public $rewardId;
    public $isEditing = false;
    public $searchCategory = '';
    public $searchReward = '';
    public $deleteId;
    public $deleteContext;

    // === RULES ===
    protected $rules = [
        'nama_hadiah'        => 'required|string|max:255',
        'reward_category_id' => 'required|exists:reward_categories,id',
        'stok'               => 'required|integer|min:0',
        'status_hadiah'      => 'required|in:Aktif,Tidak aktif',
        'gambar'             => 'nullable|image|max:2048',
    ];

    // === FITUR TAMBAH KATEGORI ===
    public function storeCategory()
    {
        $this->validate([
            'nama_kategori' => 'required|string|max:255|unique:reward_categories,nama_kategori'
        ]);

        RewardCategory::create([
            'nama_kategori' => $this->nama_kategori
        ]);

        // Reset input khusus kategori
        $this->nama_kategori = '';

        $this->dispatch('close-modal');
        session()->flash('message', 'Kategori baru berhasil ditambahkan.');
    }

    public function storeReward()
    {
        $this->validate();

        $pathGambar = null;
        if ($this->gambar) {
            $pathGambar = $this->gambar->store('rewards', 'public');
        }

        Reward::create([
            'nama_hadiah'        => $this->nama_hadiah,
            'reward_category_id' => $this->reward_category_id,
            'stok'               => $this->stok,
            'status_hadiah'      => $this->status_hadiah,
            'gambar'             => $pathGambar,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Hadiah berhasil ditambahkan.');
    }

    public function editReward($id)
    {
        $reward = Reward::findOrFail($id);

        $this->rewardId           = $reward->id;
        $this->nama_hadiah        = $reward->nama_hadiah;
        $this->reward_category_id = $reward->reward_category_id;
        $this->stok               = $reward->stok;
        $this->status_hadiah      = $reward->status_hadiah;
        $this->oldGambar          = $reward->gambar;

        $this->isEditing = true;
    }

    public function updateReward()
    {
        $this->validate();

        $reward = Reward::findOrFail($this->rewardId);
        $pathGambar = $reward->gambar;

        if ($this->gambar) {
            if ($reward->gambar) {
                Storage::disk('public')->delete($reward->gambar);
            }
            $pathGambar = $this->gambar->store('rewards', 'public');
        }

        $reward->update([
            'nama_hadiah'        => $this->nama_hadiah,
            'reward_category_id' => $this->reward_category_id,
            'stok'               => $this->stok,
            'status_hadiah'      => $this->status_hadiah,
            'gambar'             => $pathGambar,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Hadiah berhasil diperbarui.');
    }

    public function resetForm()
    {
        $this->reset(['nama_hadiah', 'reward_category_id', 'stok', 'status_hadiah', 'gambar', 'oldGambar', 'rewardId', 'isEditing']);
        $this->status_hadiah = 'Aktif';
    }

    public function setDeleteCategory($id)
    {
        $this->deleteId = $id;
        $this->deleteContext = 'category';
    }

    // Setup Hapus Hadiah
    public function setDeleteReward($id)
    {
        $this->deleteId = $id;
        $this->deleteContext = 'reward';
    }

    // Eksekusi Hapus
    public function delete()
    {
        if ($this->deleteContext == 'category') {
            $cat = RewardCategory::find($this->deleteId);

            if ($cat) {
                // --- VALIDASI RELASI (BARU) ---
                // Cek apakah kategori ini punya anak (hadiah)?
                if ($cat->rewards()->exists()) {
                    // Jika ada, batalkan hapus dan kirim pesan error
                    $this->dispatch('close-modal');
                    session()->flash('error', 'Gagal! Kategori ini tidak bisa dihapus karena masih digunakan oleh data Hadiah.');
                    return; // Stop proses
                }
                // -----------------------------

                $cat->delete();
                session()->flash('message', 'Kategori berhasil dihapus.');
            }
        } elseif ($this->deleteContext == 'reward') {
            $reward = Reward::find($this->deleteId);
            if ($reward) {
                if ($reward->gambar) {
                    Storage::disk('public')->delete($reward->gambar);
                }
                $reward->delete();
                session()->flash('message', 'Hadiah berhasil dihapus.');
            }
        }

        $this->deleteId = null;
        $this->deleteContext = null;

        $this->dispatch('close-modal');
    }

    public function render()
    {
        $rewards = Reward::query()
            ->with('category')
            ->when($this->searchReward, function ($q) {
                $q->where('nama_hadiah', 'like', '%' . $this->searchReward . '%');
            })
            ->latest()
            ->paginate(10);

        $categories = RewardCategory::query()
            ->withCount('rewards')
            ->when($this->searchCategory ?? null, function ($q) {
                $q->where('nama_kategori', 'like', '%' . $this->searchCategory . '%');
            })
            ->latest()
            ->paginate(5, pageName: 'cat_page');

        return view('livewire.admin.reward-config-page', [
            'rewards' => $rewards,
            'categories' => $categories
        ]);
    }
}
