<?php

namespace App\Livewire\Peserta;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PresencePage extends Component
{
    #[Layout('components.layouts.peserta')]

    public $title = "Presence page";
    public function render()
    {
        return view('livewire.peserta.presence-page');
    }
}
