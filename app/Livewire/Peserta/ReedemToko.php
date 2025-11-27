<?php

namespace App\Livewire\Peserta;

use App\Models\Coupon;
use App\Models\Participant;
use App\Models\Store;
use Livewire\Component;

class ReedemToko extends Component
{
    // Data Display
    public $nama_toko = '';
    public $jenis_produk = ''; // Pengganti kode_toko sesuai request

    // Form Input
    public $kodeToko = '';

    // State / Kondisi UI
    public $showSuccessModal = false;
    public $isRedeemed = false;        // User sudah pilih toko (store_id terisi)
    public $isClaimedByStore = false;  // Toko sudah klik tombol klaim (is_umkm_reedem = true)

    public function mount()
    {
        $userNip = session('current_participant_nip');
        if (!$userNip) {
            return;
        }

        $participant = Participant::where('nip', $userNip)->first();

        if ($participant) {
            // Ambil kupon milik peserta
            $coupon = Coupon::where('participant_id', $participant->id)->first();

            // Cek apakah user sudah pernah redeem ke toko
            if ($coupon && $coupon->store_id) {
                $this->isRedeemed = true;

                // Cek state apakah toko sudah melakukan klaim fisik
                $this->isClaimedByStore = (bool) $coupon->is_umkm_reedem;

                if ($coupon->store) {
                    $this->nama_toko = $coupon->store->nama_toko;
                    // Ganti kode_toko jadi jenis_produk sesuai request
                    // Pastikan di tabel 'stores' ada kolom 'jenis_produk'
                    $this->jenis_produk = $coupon->store->jenis_produk ?? '-';
                }
            }
        }
    }

    // =================================================================
    // FUNGSI 1: USER MEMASUKKAN KODE TOKO (STEP AWAL)
    // =================================================================
    // Fungsi ini dipanggil di tombol "Tukar Voucher" pada form input
    public function validateKodeToko()
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

        // Cek jika user mencoba pindah toko
        if ($coupon->store_id !== null) {
            $tokoLama = $coupon->store ? $coupon->store->nama_toko : 'Toko Lain';

            // Jika kode yang diinput BEDA dengan toko yang sudah dipilih sebelumnya
            $inputStore = Store::where('kode_toko', $this->kodeToko)->first();
            if ($inputStore->id != $coupon->store_id) {
                $this->addError('kodeToko', "Gagal! Kupon kamu sudah terkunci di {$tokoLama}.");
                return;
            }
        }

        // Simpan Data Toko ke Kupon (Kunci User ke Toko ini)
        $targetStore = Store::where('kode_toko', $this->kodeToko)->first();

        // Update hanya jika belum ada store_id (untuk menghindari update timestamp berulang)
        if (!$coupon->store_id) {
            $coupon->update([
                'store_id' => $targetStore->id,
                'redeemed_at' => now(), // Waktu user memilih toko
            ]);
        }

        // Update State Component
        $this->isRedeemed = true;
        $this->isClaimedByStore = (bool) $coupon->is_umkm_reedem; // Load state klaim toko
        $this->nama_toko = $targetStore->nama_toko;
        $this->jenis_produk = $targetStore->jenis_produk ?? '-';

        // Buka Modal
        $this->showSuccessModal = true;
    }

    // =================================================================
    // FUNGSI 2: UMKM KLIK TOMBOL KLAIM (STEP AKHIR)
    // =================================================================
    // Fungsi ini dipanggil saat tombol di dalam MODAL diklik
    public function reedemKuponToko()
    {
        $userNip = session('current_participant_nip');
        $participant = Participant::where('nip', $userNip)->first();

        if ($participant) {
            $coupon = Coupon::where('participant_id', $participant->id)->first();

            if ($coupon && $coupon->store_id) {
                // UPDATE STATE: Toko sudah melakukan klaim fisik / terima voucher
                $coupon->update([
                    'is_umkm_reedem' => true
                ]);

                // Update UI State agar tombol berubah jadi Merah/Disabled
                $this->isClaimedByStore = true;
            }
        }
    }

    public function showRedeemData()
    {
        // Hanya membuka modal untuk melihat data yang sudah ada
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
        // Pass variabel $isClaimed ke view agar tombol merah berfungsi
        return view('livewire.peserta.reedem-toko', [
            'isClaimed' => $this->isClaimedByStore
        ]);
    }
}
