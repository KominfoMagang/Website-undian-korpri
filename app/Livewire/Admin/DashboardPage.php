<?php

namespace App\Livewire\Admin;

use App\Exports\WinnersExport;
use App\Models\Coupon;
use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.admin')]
#[Title('Dashboard Admin')]

class DashboardPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Properties Data
    public $key;
    public $value;
    public $description; // Opsional: Penjelasan setting ini buat apa

    // Properties Helper
    public $settingId;
    public $isEditing = false;
    public $search = '';

    public function exportExcel()
    {
        return Excel::download(new WinnersExport, 'data-pemenang-undian.xlsx');
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
    }

    // === SIMPAN DATA BARU ===
    public function store()
    {
        $this->validate([
            'key'   => 'required|string|max:255|unique:settings,key', // Key harus unik
            'value' => 'required|string',
        ]);

        Setting::create([
            'key'   => $this->key,
            'value' => $this->value,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Pengaturan baru berhasil ditambahkan.');
    }

    // === SIAPKAN FORM EDIT ===
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        $this->settingId = $setting->id;
        $this->key       = $setting->key;
        $this->value     = $setting->value;

        $this->isEditing = true;
    }

    // === UPDATE DATA ===
    public function update()
    {
        $this->validate([
            'key'   => ['required', 'string', 'max:255', Rule::unique('settings', 'key')->ignore($this->settingId)],
            'value' => 'required|string',
        ]);

        $setting = Setting::findOrFail($this->settingId);

        $setting->update([
            'key'   => $this->key,
            'value' => $this->value,
        ]);

        $this->dispatch('close-modal');
        $this->resetForm();
        session()->flash('message', 'Pengaturan berhasil diperbarui.');
    }

    // === HELPER: RESET FORM ===
    public function resetForm()
    {
        $this->reset(['key', 'value', 'settingId', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $settings = Setting::query()
            ->when($this->search, function ($q) {
                $q->where('key', 'like', '%' . $this->search . '%')
                    ->orWhere('value', 'like', '%' . $this->search . '%');
            })
            ->latest() // Atau ->orderBy('key', 'asc')
            ->paginate(10);

        $stats = [
            'total' => Participant::count(),
            'activeCoupon' => Coupon::where('status_kupon', 'Aktif')->count()
        ];

        return view('livewire.admin.dashboard-page', [
            'stats' => $stats,
            'settings' => $settings
        ]);
    }
}
