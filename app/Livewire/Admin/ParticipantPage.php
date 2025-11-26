<?php

namespace App\Livewire\Admin;

use App\Imports\ParticipantImport;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantPage extends Component
{
    use WithPagination, WithFileUploads;

    #[Layout('components.layouts.admin')]
    #[Title('Daftar Peserta')]

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $deleteId = null;
    public $selectedParticipant = null;
    public $file_import;

    #[Rule('required|min:3', as: 'Nama Lengkap')]
    public $nama = '';
    #[Rule('required|numeric|unique:participants,nip|digits:18', as: 'NIP')]
    public $nip = '';
    #[Rule('required', as: 'Unit Kerja')]
    public $unit_kerja = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['nama', 'nip', 'unit_kerja']);
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Participant::create([
            'nama' => $this->nama,
            'nip' => $this->nip,
            'unit_kerja' => $this->unit_kerja,
        ]);

        $this->resetForm();

        $this->dispatch('close-modal');
        session()->flash('message', 'Data peserta baru berhasil ditambahkan!');
    }

    public function showDetail($id)
    {
        $this->selectedParticipant = Participant::find($id);
    }

    public function setDeleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $participant = Participant::find($this->deleteId);

            if ($participant) {
                $participant->delete();
                session()->flash('message', 'Data berhasil dihapus.');
            }

            $this->deleteId = null;
            $this->dispatch('close-modal');
        }
    }

    public function import()
    {
        $this->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        // TRIK PENTING: Perpanjang nafas PHP biar gak timeout
        // Set ke 300 detik (5 menit). Default biasanya cuma 30 detik.
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        try {
            Excel::import(new ParticipantImport, $this->file_import->getRealPath());

            $this->reset('file_import');
            $this->dispatch('close-modal-import');

            session()->flash('message', 'Sukses! data berhasil diimport.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $participants = Participant::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nip', 'like', '%' . $this->search . '%')
                    ->orWhere('unit_kerja', 'like', '%' . $this->search . '%');
            })
            ->orderBy('status_hadir', 'asc')
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return view('livewire.admin.participant-page', [
            'participants' => $participants
        ]);
    }
}
