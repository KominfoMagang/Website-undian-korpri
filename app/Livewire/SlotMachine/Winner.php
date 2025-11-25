<?php

namespace App\Livewire\SlotMachine;

use App\Models\Winner as ModelsWinner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Winner extends Component
{
    #[Layout('components.layouts.slot-machine')]
    #[Title('Daftar Pemenang Undian HUT KORPRI ke-53')]

    public $limit = 6; // Jumlah awal list bawah

    public function loadMore()
    {
        $this->limit += 6; // Tambah 6 data lagi kalau diklik
    }

    public function render()
    {
        // 1. Ambil SEMUA pemenang diurutkan dari yang PERTAMA kali menang
        // Eager load relasi 'participant' dan 'reward' biar query ringan
        $allWinners = ModelsWinner::with([
            'participant.coupons',
            'reward'
        ])->orderBy('created_at', 'asc')->get();

        // 2. Ambil 3 orang pertama untuk Podium
        // Index 0 = Juara 1, Index 1 = Juara 2, Index 2 = Juara 3
        $podium = $allWinners->take(3);

        // 3. Ambil sisanya (mulai dari index 3) untuk List Bawah
        $listWinners = $allWinners->slice(3)->take($this->limit);

        // Cek apakah masih ada sisa data untuk tombol "Load More"
        $hasMore = $allWinners->count() > (3 + $this->limit);

        return view('livewire.slot-machine.winner', [
            'podium' => $podium,
            'listWinners' => $listWinners,
            'hasMore' => $hasMore,
            'totalPemenang' => $allWinners->count()
        ]);
    }
}
