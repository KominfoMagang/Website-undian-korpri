<?php

namespace App\Livewire\RewardSystem;

use App\Models\Participant;
use App\Models\Reward;
use App\Models\Winner;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Doorprize extends Component
{
    #[Layout('components.layouts.reward-system')]
    #[Title('Gebyar Undian HUT KORPRI ke-54')]

    public function pickWinner()
    {
        return DB::transaction(function () {

            // 1. Ambil Kandidat secara Acak
            $calon = Participant::query()
                ->where('sudah_menang', false)
                ->where('status_hadir', 'Hadir') // Pastikan hanya yang hadir
                ->whereHas('coupons', function ($q) {
                    $q->where('status_kupon', 'Aktif');
                })
                ->inRandomOrder()
                // lockForUpdate mencegah data ini diambil proses lain di detik yang sama
                ->lockForUpdate()
                ->first();

            if (!$calon) {
                return null;
            }

            // Simpan hanya saat tombol "Tetapkan Pemenang" di modal diklik.
            // Tapi setidaknya query di atas sudah menjamin pengacakan yang adil.

            return [
                'id' => $calon->id,
                'kode_kupon' => $calon->coupons->first()->kode_kupon ?? '-',
                'nama' => $calon->nama,
                'unit_kerja' => $calon->unit_kerja,
                'foto' => $calon->foto_url,
            ];
        });
    }

    public function saveWinner($participantId, $rewardId)
    {
        $peserta = Participant::find($participantId);
        $reward = Reward::find($rewardId);
        $kupon = $peserta->coupons()->where('status_kupon', 'Aktif')->first();

        if ($peserta && $reward && $reward->stok > 0) {
            Winner::create([
                'participant_id' => $peserta->id,
                'reward_id' => $reward->id,
                'coupon_id' => $kupon ? $kupon->id : null,
            ]);

            $peserta->update(['sudah_menang' => true]);

            if ($kupon) {
                $kupon->update(['status_kupon' => 'Kadaluarsa']);
            }

            $reward->decrement('stok');

            $this->dispatch('pemenang-tersimpan');
        }
    }

    public function render()
    {
        $rewards = Reward::where('status_hadiah', 'Aktif')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => [
                    'id' => $item->id,
                    'nama_hadiah' => $item->nama_hadiah,
                    'gambar' => $item->gambar ? asset('static/doorprizes/' . $item->gambar) : 'https://placehold.co/300x300/png?text=No+Image',
                    'stok' => $item->stok,
                    'kategori' => $item->category->nama_kategori ?? 'Umum',
                ]];
            });

        return view('livewire.reward-system.doorprize', [
            'jsRewards' => $rewards
        ]);
    }
}
