<?php

namespace App\Livewire\SlotMachine;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Participant extends Component
{
    #[Layout('components.layouts.slot-machine')]
    #[Title('Daftar Peserta Undian HUT KORPRI ke-53')]
    
    public function render()
    {
        return view('livewire.slot-machine.participant');
    }
}
