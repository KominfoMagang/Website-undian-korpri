<?php

namespace App\Livewire\Peserta;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PresencePage extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.pages-peserta.peserta')]

    public $title = "Presence page";
    public $nip = '';
    public $showDetails = false;
    public $errorMessage = '';

    #[Validate('required|image|max:2048')]
    public $photo;

    public $validNips = [
        '123456789012345678' => [
            'nama' => 'John Doe',
            'unit_kerja' => 'Dinas Pendidikan'
        ],
        '987654321098765432' => [
            'nama' => 'Jane Smith',
            'unit_kerja' => 'Dinas Kesehatan'
        ]
    ];

    public $detailData = [];

    public function updated($propertyName)
    {
        if ($propertyName === 'nip') {

            // reset state
            $this->showDetails = false;
            $this->errorMessage = '';
            $this->detailData = [];
            $this->nip = preg_replace('/[^0-9]/', '', $this->nip);

            if (strlen($this->nip) === 18) {
                $this->validateNip();
            }
        }
    }

    public function validateNip()
    {
        if (isset($this->validNips[$this->nip])) {

            $this->showDetails = true;
            $this->errorMessage = '';

            $this->detailData = [
                'nama' => $this->validNips[$this->nip]['nama'],
                'nip' => $this->nip,
                'unit_kerja' => $this->validNips[$this->nip]['unit_kerja']
            ];
        } else {
            $this->showDetails = false;
            $this->errorMessage = 'NIP tidak ditemukan dalam database!';
        }
    }

    public function klaimKupon()
    {
        $this->validateOnly('photo');

        if ($this->showDetails) {

            $filename = $this->nip . '-' . time() . '.jpg';
            $this->photo->storeAs('selfies', $filename);

            session()->flash('success', 'Kupon berhasil diklaim & foto tersimpan!');

            return redirect()->route('halamanKupon');
        }
    }

    public function render()
    {
        return view('livewire.peserta.presence-page');
    }
}
