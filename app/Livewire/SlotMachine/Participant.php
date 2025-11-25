<?php

namespace App\Livewire\SlotMachine;

use App\Models\Participant as ModelsParticipant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Participant extends Component
{
    use WithPagination;

    #[Layout('components.layouts.slot-machine')]
    #[Title('Daftar Peserta Undian HUT KORPRI ke-53')]

    // Property untuk Filter & Search
    public $search = '';
    public $instansi = '';
    public $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedInstansi()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Ambil daftar unit kerja unik untuk dropdown filter
        $unitKerjaList = ModelsParticipant::select('unit_kerja')->distinct()->pluck('unit_kerja');

        // Query Utama
        $participants = ModelsParticipant::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nip', 'like', '%' . $this->search . '%');
            })
            ->when($this->instansi, function ($query) {
                $query->where('unit_kerja', $this->instansi);
            })
            // Urutkan: Yang Hadir duluan, baru abjad nama
            ->orderBy('status_hadir', 'desc')
            ->orderBy('nama', 'asc')
            ->paginate(10); // Tampilkan 10 per halaman

        return view('livewire.slot-machine.participant', [
            'participants' => $participants,
            'unitKerjaList' => $unitKerjaList,
            'totalPeserta' => ModelsParticipant::count(),
            'totalHadir' => ModelsParticipant::where('status_hadir', 'Hadir')->count()
        ]);
    }
}
