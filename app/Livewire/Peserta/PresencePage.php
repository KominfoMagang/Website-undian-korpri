<?php

namespace App\Livewire\Peserta;

use App\Models\Participant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.pages-peserta.peserta')]
#[Title("Halaman Absensi Peserta")]
class PresencePage extends Component
{
    use WithFileUploads;

    protected const CENTER_LAT = -7.311787177703361;
    protected const CENTER_LNG = 108.19932506578725;
    protected const RADIUS_METERS = 500;
    protected const EARTH_RADIUS = 6371000;

    public string $nip = '';
    public $photo;
    public bool $agreement = false;

    public bool $showDetails = false;
    public string $errorMessage = '';
    public array $detailData = [];

    public bool $locationGranted = false;
    public string $locationErrorMessage = '';
    public ?float $userLat = null;
    public ?float $userLng = null;

    public function mount()
    {
        // Cek apakah user sudah memiliki session NIP (sudah pernah klaim)
        if (session()->has('current_participant_nip')) {
            return redirect()->route('halamanKupon');
        }
    }

    public function updatedNip()
    {
        $this->resetState();
        $this->nip = preg_replace('/[^0-9]/', '', $this->nip);

        if (strlen($this->nip) >= 5) {
            $this->validateNip();
        }
    }

    public function resetState()
    {
        $this->showDetails = false;
        $this->errorMessage = '';
        $this->detailData = [];
    }

    public function validateNip()
    {
        $participant = Participant::where('nip', $this->nip)->first();

        if (!$participant) {
            $this->errorMessage = 'NIP tidak ditemukan dalam database peserta!';
            return;
        }

        if ($participant->coupons()->exists()) {
            $this->errorMessage = 'Peserta dengan NIP ini sudah melakukan presensi dan memiliki kupon!';
            return;
        }

        $this->showDetails = true;
        $this->detailData = [
            'id'         => $participant->id,
            'nama'       => $participant->nama,
            'nip'        => $participant->nip,
            'unit_kerja' => $participant->unit_kerja
        ];
    }

    public function checkLocation($lat, $lng)
    {
        $this->userLat = $lat;
        $this->userLng = $lng;

        $distance = $this->calculateDistance($lat, $lng);

        if ($distance <= self::RADIUS_METERS) {
            $this->locationGranted = true;
            $this->locationErrorMessage = '';
            $this->dispatch('location-granted');
        } else {
            $this->locationGranted = false;
            $this->locationErrorMessage = 'Anda berada di luar area acara (' . round($distance) . ' meter). Silakan mendekat ke lokasi.';
            $this->dispatch('location-radius-error');
        }
    }

    public function locationFailed($code)
    {
        $this->locationGranted = false;
        $messages = [
            1 => 'Akses lokasi ditolak. Mohon izinkan akses lokasi di browser Anda.',
            2 => 'Posisi tidak tersedia. Pastikan GPS aktif.',
            3 => 'Waktu permintaan lokasi habis. Silakan coba lagi.'
        ];
        $this->locationErrorMessage = $messages[$code] ?? 'Error lokasi tidak diketahui.';
        $this->dispatch('location-system-error');
    }

    public function klaimKupon()
    {
        $this->validate([
            'photo' => 'required|image|max:2048',
        ], [
            'photo.required' => 'Foto selfie wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        if (!$this->locationGranted) {
            return $this->addError('location', 'Posisi Anda belum terverifikasi di area acara.');
        }

        if (!$this->agreement) {
            return $this->addError('agreement', 'Anda harus menyetujui pernyataan kebenaran data.');
        }

        if (!$this->showDetails || !isset($this->detailData['id'])) {
            return;
        }

        DB::beginTransaction();

        try {
            $participant = Participant::findOrFail($this->detailData['id']);

            if ($participant->coupons()->exists()) {
                throw new \Exception('NIP ini baru saja melakukan klaim.');
            }

            $path = $this->uploadPhoto($participant->nip);

            $participant->update([
                'foto'         => basename($path),
                'status_hadir' => 'Hadir',
                'latitude'     => $this->userLat,
                'longitude'    => $this->userLng,
            ]);

            $kodeKupon = $this->generateUniqueCoupon($participant);

            DB::commit();

            session()->flash('success', 'Berhasil! Kode Kupon Anda: ' . $kodeKupon);
            session(['current_participant_nip' => $participant->nip]);

            return redirect()->route('halamanKupon');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            $this->addError('system', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function uploadPhoto($nip): string
    {
        $filename = 'presensi_' . $nip . '_' . time() . '.' . $this->photo->getClientOriginalExtension();
        return $this->photo->storeAs('selfies', $filename, 'public');
    }

    // Race condition klaim kupon perlu dicek
    private function generateUniqueCoupon(Participant $participant)
    {
        $attempts = 0;

        do {
            try {
                $kode = mt_rand(100000, 999999);

                $participant->coupons()->create([
                    'kode_kupon'   => $kode,
                    'status_kupon' => 'Aktif'
                ]);

                return $kode;
            } catch (QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $attempts++;
                    if ($attempts >= 5) {
                        throw new \Exception("Gagal generate kode unik. Silakan coba lagi.");
                    }
                    continue;
                }
                throw $e;
            }
        } while (true);
    }

    private function calculateDistance($latUser, $lngUser)
    {
        $latDelta = deg2rad($latUser - self::CENTER_LAT);
        $lonDelta = deg2rad($lngUser - self::CENTER_LNG);

        $a = sin($latDelta / 2) ** 2 +
            cos(deg2rad(self::CENTER_LAT)) * cos(deg2rad($latUser)) *
            sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS * $c;
    }

    public function render()
    {
        return view('livewire.peserta.presence-page');
    }
}
