<?php

namespace App\Livewire\Admin;

use App\Models\Store;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class StorePage extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Daftar Toko')]

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $deleteId = null;

    #[Validate('required|min:3')]
    public $nama_toko;

    #[Validate('required|numeric|digits_between:5,6|unique:stores,kode_toko')]
    public $kode_toko;

    public function generateKodeToko()
    {
        $code = rand(10000, 999999);

        while (Store::where('kode_toko', $code)->exists()) {
            $code = rand(10000, 999999);
        }

        $this->kode_toko = $code;
    }

    public function store()
    {
        $this->validate();

        Store::create([
            'nama_toko' => $this->nama_toko,
            'kode_toko' => $this->kode_toko,
        ]);

        $this->reset(['nama_toko', 'kode_toko']);
        $this->dispatch('close-modal');

        session()->flash('message', 'Toko berhasil ditambahkan.');
    }

    public function setDeleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $store = Store::find($this->deleteId);

            if ($store) {
                $store->delete();
                session()->flash('message', 'Data berhasil dihapus.');
            }

            $this->deleteId = null;
            $this->dispatch('close-modal');
        }
    }

    public function render()
    {
        $stores = Store::query()
            ->withCount('coupons')
            ->when($this->search, function ($query) {
                $query->where('nama_toko', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_toko', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_toko', 'asc')
            ->paginate(10);

        return view('livewire.admin.store-page', [
            'stores' => $stores
        ]);
    }
}
