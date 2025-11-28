<?php

namespace App\Livewire\Admin;

use App\Models\Reward;
use App\Models\RewardCategory;
use Illuminate\Support\Facades\File;
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

        $namaFile = null;

        if ($this->gambar) {
            $namaFile = $this->gambar->hashName();

            // Path Tujuan (Public)
            $folderTujuan = public_path('static/doorprizes');

            // Path Sumber (Temporary Livewire)
            $sourcePath = $this->gambar->getRealPath();

            // 1. Pastikan folder tujuan ada
            if (!File::exists($folderTujuan)) {
                // Pakai 0775 (standar Linux) bukan 0777
                File::makeDirectory($folderTujuan, 0775, true, true);
            }

            // 2. Cek apakah file sumber benar-benar ada?
            if (File::exists($sourcePath)) {
                // Gunakan COPY atau MOVE (Coba move dulu di Linux, lebih clean)
                // Kalau move gagal, baru copy.
                try {
                    // Di Linux, move() biasanya lebih disukai karena tidak meninggalkan sampah
                    $this->gambar->move($folderTujuan, $namaFile);
                } catch (\Exception $e) {
                    // Fallback ke copy jika move gagal
                    File::copy($sourcePath, $folderTujuan . '/' . $namaFile);
                }
            } else {
                // Error Handling jika file temp hilang (biasanya karena upload gagal/timeout)
                $this->addError('gambar', 'Gagal upload. File sementara tidak ditemukan. Cek permission storage.');
                return;
            }
        }

        Reward::create([
            'nama_hadiah'        => $this->nama_hadiah,
            'reward_category_id' => $this->reward_category_id,
            'stok'               => $this->stok,
            'status_hadiah'      => $this->status_hadiah,
            'gambar'             => $namaFile,
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
        $namaFile = $reward->gambar; // Default: pakai nama file lama

        if ($this->gambar) {
            // 1. Hapus gambar lama jika ada (Tetap dipertahankan)
            if ($reward->gambar) {
                $pathLama = public_path('static/doorprizes/' . $reward->gambar);
                if (File::exists($pathLama)) {
                    File::delete($pathLama);
                }
            }

            // 2. PROSES UPLOAD BARU (Logic "Anti-Badai")
            $namaFile = $this->gambar->hashName();
            $folderTujuan = public_path('static/doorprizes');
            $sourcePath = $this->gambar->getRealPath();

            // A. Pastikan folder tujuan ada & writable
            if (!File::exists($folderTujuan)) {
                // Gunakan 0775 buat Linux Production
                try {
                    File::makeDirectory($folderTujuan, 0775, true, true);
                } catch (\Exception $e) { /* Ignore if exists */
                }
            }

            // B. Cek File Sumber & Eksekusi Pindah
            if (File::exists($sourcePath)) {
                try {
                    // Prioritas 1: MOVE (Lebih bersih di Linux)
                    $this->gambar->move($folderTujuan, $namaFile);
                } catch (\Exception $e) {
                    // Prioritas 2: COPY (Fallback jika Move gagal/Windows)
                    File::copy($sourcePath, $folderTujuan . '/' . $namaFile);
                }
            } else {
                $this->addError('gambar', 'Gagal upload. File sementara hilang.');
                return;
            }
        }

        $reward->update([
            'nama_hadiah'        => $this->nama_hadiah,
            'reward_category_id' => $this->reward_category_id,
            'stok'               => $this->stok,
            'status_hadiah'      => $this->status_hadiah,
            'gambar'             => $namaFile,
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
                // Validasi Relasi
                if ($cat->rewards()->exists()) {
                    $this->dispatch('close-modal');
                    session()->flash('error', 'Gagal! Kategori ini tidak bisa dihapus karena masih digunakan oleh data Hadiah.');
                    return;
                }

                $cat->delete();
                session()->flash('message', 'Kategori berhasil dihapus.');
            }
        } elseif ($this->deleteContext == 'reward') {
            $reward = Reward::find($this->deleteId);

            if ($reward) {
                // --- UPDATE LOGIC HAPUS GAMBAR ---
                if ($reward->gambar) {
                    // Arahkan ke folder public/static/doorprizes
                    $pathGambar = public_path('static/doorprizes/' . $reward->gambar);

                    // Cek file ada gak? Kalau ada, hapus.
                    if (File::exists($pathGambar)) {
                        File::delete($pathGambar);
                    }
                }
                // ---------------------------------

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
