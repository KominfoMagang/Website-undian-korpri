<?php

namespace App\Livewire\SlotMachine;

use App\Models\Participant;
use App\Models\Reward;
use App\Models\Winner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Doorprize extends Component
{
    #[Layout('components.layouts.slot-machine')]
    #[Title('Gebyar Undian HUT KORPRI ke-53')]

    public function pickWinner()
    {
        $calon = Participant::where('sudah_menang', false)
            ->whereHas('coupons', function ($q) {
                $q->where('status_kupon', 'Aktif'); // Pastikan punya kupon aktif
            })
            ->inRandomOrder()
            ->first();

        if (!$calon) {
            return null;
        }

        $kupon = $calon->coupons()->where('status_kupon', 'Aktif')->first()->kode_kupon;

        return [
            'id' => $calon->id,
            'kode_kupon' => $kupon,
            'nama' => $calon->nama,
            'unit_kerja' => $calon->unit_kerja,
            'foto' => $calon->foto ? asset('storage/' . $calon->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($calon->nama),
        ];
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
                'coupon_id' => $kupon->id,
            ]);

            $peserta->update(['sudah_menang' => true]);
            if ($kupon) {
                $kupon->update(['status_kupon' => 'Kadaluarsa']);
            }
            $reward->decrement('stok');

            return redirect()->route('slot-machine.undian');
        }
    }

    public function render()
    {
        $rewards = Reward::where('status_hadiah', 'Aktif')
            ->where('stok', '>', 0)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => [
                    'id' => $item->id,
                    'nama_hadiah' => $item->nama_hadiah,
                    'gambar' => $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/300x300/png?text=No+Image',
                    'stok' => $item->stok
                ]];
            });

        return view('livewire.slot-machine.doorprize', [
            'jsRewards' => $rewards
        ]);
    }
}
