<?php

namespace App\Livewire\Admin;

use App\Models\Participant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ParticipantPage extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Daftar Peserta')]

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $deleteId = null;
    public $selectedParticipant = null;

    public function updatingSearch()
    {
        $this->resetPage();
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
