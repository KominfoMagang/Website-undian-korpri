<?php

namespace App\Livewire\Peserta;

use App\Models\Coupon;
use App\Models\Participant;
use App\Models\Store;
use Livewire\Component;

class ReedemToko extends Component
{
    public $nama_toko = '';
    public $kode_toko = '';
    public $kodeToko = '';

    public $showSuccessModal = false;
    public $isRedeemed = false; 

    public function mount()
    {

        $userNip = session('current_participant_nip');
        if (!$userNip) {
            return;
        }

        $participant = Participant::where('nip', $userNip)->first();

        if ($participant) {
            $coupon = Coupon::where('participant_id', $participant->id)->first();
            if ($coupon && $coupon->store_id) {
                $this->isRedeemed = true;
                if ($coupon->store) {
                    $this->nama_toko = $coupon->store->nama_toko;
                    $this->kode_toko = $coupon->store->kode_toko;
                }
            }
        }
    }

    public function reedemKuponToko()
    {
        $this->validate(
            [
                'kodeToko' => 'required|exists:stores,kode_toko'
            ],
            [
                'kodeToko.required' => 'Kamu belum isi kode toko :3',
                'kodeToko.exists' => 'Kode Toko tidak ditemukan / salah ketik.',
            ]
        );

        $userNip = session('current_participant_nip');
        $participant = Participant::where('nip', $userNip)->first();

        if (!$participant) {
            $this->addError('kodeToko', 'Sesi habis, silakan login ulang.');
            return;
        }

        $coupon = Coupon::where('participant_id', $participant->id)
            ->lockForUpdate()
            ->first();

        if (!$coupon) {
            $this->addError('kodeToko', 'Kamu belum punya kupon undian.');
            return;
        }

        // ==========================================================
        // LOGIC UTAMA: SATU KUPON HANYA UNTUK SATU TOKO
        // ==========================================================

        if ($coupon->store_id !== null) {
            $tokoLama = $coupon->store ? $coupon->store->nama_toko : 'Toko Lain';

            $this->addError('kodeToko', "Gagal! Kupon kamu sudah dipakai di {$tokoLama}. Tidak bisa pindah toko.");
            return;
        }

        $targetStore = Store::where('kode_toko', $this->kodeToko)->first();
        $coupon->update([
            'store_id' => $targetStore->id,
            'redeemed_at' => now(),
        ]);
        $this->isRedeemed = true;
        $this->nama_toko = $targetStore->nama_toko;
        $this->kode_toko = $targetStore->kode_toko;

        $this->showSuccessModal = true;
    }
    public function showRedeemData()
    {
        $this->showSuccessModal = true;
    }

    public function closeModal()
    {
        $this->showSuccessModal = false;
        $this->kodeToko = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.peserta.reedem-toko');
    }
}
