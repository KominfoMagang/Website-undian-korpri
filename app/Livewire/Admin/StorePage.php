<?php

namespace App\Livewire\Admin;

use App\Imports\StoreImport;
use App\Models\Store;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StorePage extends Component
{
    use WithPagination, WithFileUploads;

    #[Layout('components.layouts.admin')]
    #[Title('Daftar Toko')]

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $deleteId = null;
    public $storeId;
    public $isEditing = false;
    public $storeCoupons;
    public $selectedStore;
    public $selectedStoreId;
    public $file_import;

    public $nama_toko;
    public $kode_toko;
    public $jenis_produk;
    public $stok;

    public function generateKodeToko()
    {
        $code = rand(0, 999);

        while (Store::where('kode_toko', $code)->exists()) {
            $code = rand(0, 999);
        }

        $this->kode_toko = $code;
    }

    public function store()
    {
        $this->validate([
            'nama_toko'    => 'required|string|max:255',
            'kode_toko'    => 'required|unique:stores,kode_toko|numeric|min:1|max:3',
            'jenis_produk' => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
        ]);

        Store::create([
            'nama_toko'    => $this->nama_toko,
            'kode_toko'    => $this->kode_toko,
            'jenis_produk' => $this->jenis_produk,
            'stok'         => $this->stok,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
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

    public function showStoreCoupons($id)
    {
        $this->selectedStore = Store::find($id);
        $this->selectedStoreId = $id;

        $this->resetPage(pageName: 'coupon_page');
    }

    public function editStore($id)
    {
        $store = Store::findOrFail($id);

        $this->storeId      = $store->id;
        $this->nama_toko    = $store->nama_toko;
        $this->kode_toko    = $store->kode_toko;
        $this->jenis_produk = $store->jenis_produk;
        $this->stok         = $store->stok;

        $this->isEditing = true;
    }

    public function updateStore()
    {
        $this->validate([
            'nama_toko'    => 'required|string|max:255',
            'kode_toko'    => ['required', 'numeric', 'digits_between:5,6', Rule::unique('stores', 'kode_toko')->ignore($this->storeId)],
            'jenis_produk' => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
        ]);

        $store = Store::findOrFail($this->storeId);
        $store->update([
            'nama_toko'    => $this->nama_toko,
            'kode_toko'    => $this->kode_toko,
            'jenis_produk' => $this->jenis_produk,
            'stok'         => $this->stok,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Data Toko berhasil diperbarui.');
    }

    public function resetForm()
    {
        $this->reset(['nama_toko', 'kode_toko', 'jenis_produk', 'stok', 'storeId', 'isEditing']);
    }

    public function import()
    {
        $this->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new StoreImport, $this->file_import);

            $this->reset('file_import');
            $this->dispatch('close-modal');
            session()->flash('message', 'Data Toko berhasil diimport!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import: ' . $e->getMessage());
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

        $couponsInModal = null;
        if ($this->selectedStoreId) {
            $couponsInModal = \App\Models\Coupon::with('participant')
                ->where('store_id', $this->selectedStoreId)
                ->latest()
                // PENTING: Kasih nama halaman beda ('coupon_page')
                ->paginate(5, pageName: 'coupon_page');
        }

        return view('livewire.admin.store-page', [
            'stores' => $stores,
            'modalCoupons' => $couponsInModal
        ]);
    }
}
