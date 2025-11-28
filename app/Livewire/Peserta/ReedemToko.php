<?php

namespace App\Livewire\Peserta;

use App\Models\Coupon;
use App\Models\Participant;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReedemToko extends Component
{
    public $nama_toko = '';
    public $jenis_produk = '';
    public $kodeToko = '';

    public $showSuccessModal = false;
    public $isRedeemed = false;
    public $isClaimedByStore = false;
    public $isStokHabis = false;

    public function mount()
    {
        $userNip = session('current_participant_nip');
        if (!$userNip) return;

        $participant = Participant::where('nip', $userNip)->first();
        if (!$participant) return;

        $coupon = Coupon::with('store')->where('participant_id', $participant->id)->first();
        if (!$coupon) return;

        if ($coupon->store_id) {
            $this->isRedeemed = true;
            $this->isClaimedByStore = (bool) $coupon->is_umkm_reedem;
            $this->nama_toko = $coupon->store->nama_toko ?? '';
            $this->jenis_produk = $coupon->store->jenis_produk ?? '-';
        }
    }

    public function updatedKodeToko()
    {
        // Reset error dan flag
        $this->resetErrorBag('kodeToko');
        $this->isStokHabis = false;

        if (empty($this->kodeToko)) {
            return;
        }

        // Cek apakah kode toko valid
        $store = Store::where('kode_toko', $this->kodeToko)->first();

        if (!$store) {
            return;
        }

        // Hitung jumlah kupon yang sudah diklaim di toko ini
        $jumlahKuponDiklaim = Coupon::where('store_id', $store->id)
            ->whereNotNull('store_id')
            ->count();

        // Set flag jika stok habis
        if ($jumlahKuponDiklaim >= $store->stok) {
            $this->isStokHabis = true;
        }
    }

    public function reedemKuponToko()
    {
        $this->validate([
            'kodeToko' => 'required|exists:stores,kode_toko'
        ]);

        $userNip = session('current_participant_nip');
        $participant = Participant::where('nip', $userNip)->first();

        if (!$participant) {
            $this->addError('kodeToko', 'Participant tidak ditemukan.');
            return;
        }

        $store = Store::where('kode_toko', $this->kodeToko)->first();

        if (!$store) {
            $this->addError('kodeToko', 'Toko tidak ditemukan.');
            return;
        }

        try {
            DB::transaction(function () use ($participant, $store) {
                $coupon = Coupon::where('participant_id', $participant->id)->first();

                if (!$coupon) {
                    throw new \Exception('Kupon tidak ditemukan.');
                }

                if ($coupon->store_id) {
                    $this->isRedeemed = true;
                    $this->isClaimedByStore = (bool) $coupon->is_umkm_reedem;
                    $this->nama_toko = $coupon->store->nama_toko;
                    $this->jenis_produk = $coupon->store->jenis_produk ?? '-';
                    return;
                }

                $jumlahKuponDiklaim = Coupon::where('store_id', $store->id)
                    ->whereNotNull('store_id')
                    ->count();

                if ($jumlahKuponDiklaim >= $store->stok) {
                    $this->isStokHabis = true;
                    throw new \Exception('Stok kupon toko ini sudah habis. Silakan pilih toko lain.');
                }

                $coupon->update([
                    'store_id' => $store->id,
                    'redeemed_at' => now()
                ]);

                $this->isRedeemed = true;
                $this->nama_toko = $store->nama_toko;
                $this->jenis_produk = $store->jenis_produk ?? '-';
            });

            $this->showSuccessModal = true;
        } catch (\Exception $e) {
            $this->addError('kodeToko', $e->getMessage());
            return;
        }
    }

    public function claimVoucherUmkm()
    {
        $userNip = session('current_participant_nip');
        $participant = Participant::where('nip', $userNip)->first();
        if (!$participant) return;

        $coupon = Coupon::where('participant_id', $participant->id)->whereNotNull('store_id')->first();
        if (!$coupon) return;

        if (!$coupon->is_umkm_reedem) {
            $coupon->update(['is_umkm_reedem' => true]);
        }

        $this->isClaimedByStore = true;
        $this->showSuccessModal = false;
    }

    public function showRedeemData()
    {
        $this->showSuccessModal = true;
    }

    public function closeModal()
    {
        $this->showSuccessModal = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.peserta.reedem-toko', [
            'isClaimed' => $this->isClaimedByStore
        ]);
    }
}
