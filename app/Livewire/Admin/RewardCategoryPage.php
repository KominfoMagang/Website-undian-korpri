<?php

namespace App\Livewire\Admin;

use App\Models\RewardCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Title('Manajemen Kategori Hadiah')]
#[Layout('components.layouts.admin')]
class RewardCategoryPage extends Component
{
    public $categories;
    public $is_modal_open = false;

    // Form props
    public $category_id;
    public $nama_kategori = '';

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = RewardCategory::orderBy('id')->get();
    }

    // open modal. $reset=false kalau dipanggil dari edit sehingga nilai form tetap ada
    public function openModal($reset = true)
    {
        if ($reset) {
            $this->resetForm();
        }

        $this->is_modal_open = true;
    }

    public function closeModal()
    {
        $this->is_modal_open = false;
        $this->resetErrorBag();
    }

    protected function resetForm()
    {
        $this->reset(['category_id', 'nama_kategori']);
        $this->resetErrorBag();
    }

    public function saveCategory()
    {
        $this->validate([
            'nama_kategori' => 'required|string|max:100|unique:reward_categories,nama_kategori,' . $this->category_id,
        ]);

        try {
            $data = ['nama_kategori' => $this->nama_kategori];

            if ($this->category_id) {
                RewardCategory::find($this->category_id)->update($data);
                $message = 'Kategori berhasil diperbarui.';
            } else {
                RewardCategory::create($data);
                $message = 'Kategori berhasil ditambahkan.';
            }

            $this->loadCategories();
            $this->resetForm();
            $this->closeModal();
            session()->flash('success_message', $message);

        } catch (Throwable $e) {
            report($e);
            session()->flash('error_message', 'Terjadi kesalahan saat menyimpan kategori.');
        }
    }

    public function editCategory($id)
    {
        $category = RewardCategory::findOrFail($id);

        $this->category_id = $category->id;
        $this->nama_kategori = $category->nama_kategori;

        // buka modal tanpa mereset form (agar nilai edit tidak hilang)
        $this->openModal(false);
    }

    public function deleteCategory($id)
    {
        try {
            // cek relasi rewards (pastikan model RewardCategory punya relasi rewards())
            if (RewardCategory::findOrFail($id)->rewards()->exists()) {
                session()->flash('error_message', 'Tidak dapat menghapus kategori karena masih digunakan oleh beberapa hadiah.');
                return;
            }

            RewardCategory::destroy($id);
            $this->loadCategories();
            session()->flash('success_message', 'Kategori berhasil dihapus.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error_message', 'Gagal menghapus kategori.');
        }
    }

    public function render()
    {
        return view('livewire.admin.reward-category-page');
    }
}
