<?php

namespace App\Livewire\RewardSystem;

use App\Models\Winner as ModelsWinner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Winner extends Component
{
    #[Layout('components.layouts.reward-system')]
    #[Title('Daftar Pemenang Undian HUT KORPRI ke-54')]

    public $limit = 6; // Jumlah awal list bawah

    public function loadMore()
    {
        $this->limit += 6; // Tambah 6 data lagi kalau diklik
    }

    public function render()
    {
        $allWinners = ModelsWinner::with([
            'participant.coupons',
            'reward.category' // Pastikan relasi ke kategori diload
        ])->orderBy('created_at', 'desc')->get();

        // 1. Filter Pemenang Kategori UTAMA (Masuk Podium)
        $podiumWinners = $allWinners->filter(function ($winner) {
            // Sesuaikan string 'Utama' dengan nama di database Anda (case-sensitive biasanya)
            return $winner->reward->category->nama_kategori === 'Utama';
        });

        // 2. Filter Pemenang Kategori UMUM/LAINNYA (Masuk List Bawah)
        $otherWinners = $allWinners->filter(function ($winner) {
            return $winner->reward->category->nama_kategori !== 'Utama';
        });

        // Pagination Manual untuk List Bawah
        $listWinners = $otherWinners->take($this->limit);
        $hasMore = $otherWinners->count() > $this->limit;

        return view('livewire.reward-system.winner', [
            'podiumWinners' => $podiumWinners, // Kirim collection, bukan cuma 1 orang
            'listWinners' => $listWinners,
            'hasMore' => $hasMore,
            'totalPemenang' => $allWinners->count()
        ]);
    }
}
