<?php

namespace App\Livewire\SlotMachine;

use App\Models\Participant;
use App\Models\Reward;
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
            ->where('status_hadir', 'Hadir')
            ->inRandomOrder()
            ->first();

        if (!$calon) {
            return null;
        }

        return [
            'id' => $calon->id,
            'nip' => $calon->nip,
            'nama' => $calon->nama,
            'unit_kerja' => $calon->unit_kerja,
            'foto' => $calon->foto ? asset('storage/' . $calon->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($calon->nama),
        ];
    }

    public function saveWinner($participantId, $rewardId)
    {
        $peserta = Participant::find($participantId);
        $reward = Reward::find($rewardId);

        if ($peserta && $reward && $reward->stok > 0) {
            Winner::create([
                'peserta_id' => $peserta->id,
                'reward_id' => $reward->id,
                'coupon_id' => null,
            ]);

            $peserta->update(['sudah_menang' => true]);
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
