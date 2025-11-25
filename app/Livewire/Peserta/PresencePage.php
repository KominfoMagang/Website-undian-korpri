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

    public $detailData = [];
    public $agreement = false;

    public $locationGranted = false;
    public $locationErrorMessage = '';

    public $userLat;
    public $userLng;

    // titik pusat acara (bisa pindah ke config/env)
    public $centerLat = -7.316562875296225;
    public $centerLng = 108.19676824068117;
    public $radiusMeters = 500;

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

    public function updated($propertyName)
    {
        if ($propertyName === 'nip') {
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
                'nama'       => $this->validNips[$this->nip]['nama'],
                'nip'        => $this->nip,
                'unit_kerja' => $this->validNips[$this->nip]['unit_kerja']
            ];
        } else {
            $this->showDetails = false;
            $this->errorMessage = 'NIP tidak ditemukan dalam database!';
        }
    }

    public function checkLocation($lat, $lng)
    {
        $this->userLat = $lat;
        $this->userLng = $lng;

        $distance = $this->calculateDistanceMeters(
            $this->centerLat,
            $this->centerLng,
            $lat,
            $lng
        );

        if ($distance <= $this->radiusMeters) {
            $this->locationGranted = true;
            $this->locationErrorMessage = '';
            $this->dispatch('location-granted');
        } else {
            $this->locationGranted = false;
            $this->locationErrorMessage = 'Anda berada di luar area yang diizinkan (' . round($distance) . ' meter).';

            $this->dispatch('location-radius-error');
        }
    }

    public function locationFailed($code)
    {
        $this->locationGranted = false;

        if ($code == 1) {
            $this->locationErrorMessage = 'Akses lokasi ditolak. Mohon izinkan akses lokasi untuk melanjutkan.';
            $this->dispatch('permission-blocked');
        }
        else {
            $errorMessages = [
                2 => 'Posisi tidak tersedia. Pastikan GPS aktif.',
                3 => 'Waktu permintaan lokasi habis. Silakan coba lagi.'
            ];
            $this->locationErrorMessage = $errorMessages[$code] ?? 'Error lokasi tidak diketahui.';
            $this->dispatch('location-system-error');
        }
    }

    /**
     * Haversine formula untuk hitung jarak 2 titik (meter)
     */
    private function calculateDistanceMeters($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) ** 2 +
            cos($lat1) * cos($lat2) *
            sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }


    public function klaimKupon()
    {
        // Pastikan posisi sudah dicek & di dalam radius
        if (!$this->locationGranted) {
            $this->addError('location', 'Anda harus berada di area acara untuk mengklaim kupon.');
            return;
        }

        // Validasi agreement checkbox
        if (!$this->agreement) {
            $this->addError('agreement', 'Anda harus menyetujui pernyataan terlebih dahulu.');
            return;
        }

        // Validasi foto
        $this->validate([
            'photo' => 'required|image|max:2048'
        ], [
            'photo.required' => 'Foto selfie wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        if ($this->showDetails && $this->photo) {
            try {
                // Simpan foto
                $filename = $this->nip . '-' . time() . '.' . $this->photo->getClientOriginalExtension();
                $this->photo->storeAs('selfies', $filename, 'public');

                session()->flash('success', 'Kupon berhasil diklaim & foto tersimpan!');

                return redirect()->route('halamanKupon');
            } catch (\Exception $e) {
                $this->addError('system', 'Terjadi kesalahan sistem. Silakan coba lagi.');
                return;
            }
        }
    }

    public function render()
    {
        return view('livewire.peserta.presence-page');
    }
}
