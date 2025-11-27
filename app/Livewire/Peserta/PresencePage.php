<?php

namespace App\Livewire\Peserta;

use App\Models\Coupon;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;

#[Layout('components.layouts.Pages-peserta.peserta')]
#[Title("Halaman Absensi Peserta")]
class PresencePage extends Component
{
    use WithFileUploads;

    // diskominfo : -7.31175525292628, 108.19931433695206
    // Bale kota : -7.316546993522394, 108.19674640365119
    // rumah : -7.230234323966636, 108.1545507815288
    

    protected const CENTER_LAT = -7.316546993522394;
    protected const CENTER_LNG = 108.19674640365119;
    protected const RADIUS_METERS = 500;
    protected const EARTH_RADIUS = 6371000;
    protected const MAX_UPLOAD_SIZE = 10240;

    // Properties
    public string $nip = '';
    public $photo;
    public bool $agreement = false;

    // UI States
    public bool $showDetails = false;
    public string $errorMessage = '';
    public array $detailData = [];

    // Location States
    public bool $locationGranted = false;
    public string $locationErrorMessage = '';
    public ?float $userLat = null;
    public ?float $userLng = null;

    public function mount()
    {
        if (session()->has('current_participant_nip')) {
            return redirect()->route('halamanKupon');
        }
    }

    public function updatedNip()
    {
        $this->resetState();
        // Hanya ambil angka
        $this->nip = preg_replace('/[^0-9]/', '', $this->nip);

        // Validasi otomatis jika panjang NIP mencukupi (misal 18 digit)
        if (strlen($this->nip) >= 18) {
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

        // Pastikan nama relasi di Model Participant adalah 'coupons'
        if ($participant->coupons()->exists()) {
            $this->errorMessage = 'Peserta dengan NIP ini sudah melakukan presensi!';
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
            $this->locationErrorMessage = 'Anda berada di luar area acara (' . round($distance) . ' meter). Silakan mendekat.';
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

        if ($this->checkRateLimit()) {
            return;
        }
        if (!$this->validateClaimRequest()) {
            return;
        }

        $uploadedPath = null;

        try {
            $uploadedPath = $this->uploadPhoto($this->detailData['nip']);
            $couponCode = $this->processTransaction($uploadedPath);
            $this->handleSuccess($couponCode);
        } catch (Exception $e) {
            $this->handleFailure($e, $uploadedPath);
        }
    }

    private function checkRateLimit()
    {
        $throttleKey = 'claim-coupon:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('system', "Mohon tunggu $seconds detik sebelum mencoba lagi.");
            return true;
        }

        RateLimiter::hit($throttleKey, 10);
        return false;
    }

    private function validateClaimRequest()
    {
        $this->validate([
            'photo' => 'required|image|max:' . self::MAX_UPLOAD_SIZE,
        ], [
            'photo.required' => 'Foto selfie wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto terlalu besar.',
        ]);

        if (!$this->locationGranted || is_null($this->userLat) || is_null($this->userLng)) {
            $this->addError('location', 'Posisi Anda belum terverifikasi di area acara.');
            return false;
        }

        if (!$this->agreement) {
            $this->addError('agreement', 'Anda harus menyetujui pernyataan kebenaran data.');
            return false;
        }

        if (!$this->showDetails || !isset($this->detailData['id'])) {
            $this->addError('system', 'Data peserta tidak valid. Silakan refresh halaman.');
            return false;
        }

        return true;
    }

    private function uploadPhoto($nip)
    {
        $filename = 'selfie_' . $nip . '_' . time() . '.jpg';
        // return $this->photo->storeAs('photos', $filename, 'public');
        return $this->photo->storeAs('photos', $filename, 's3');
    }

    /**
     * Menjalankan transaksi database
     * @throws Exception
     */
    private function processTransaction($uploadedPath)
    {
        return DB::transaction(function () use ($uploadedPath) {
            $participant = Participant::where('id', $this->detailData['id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($participant->coupons()->exists()) {
                throw new Exception('NIP ini sudah memiliki kupon (Gagal Double Claim).');
            }


            $availableCoupon = Coupon::whereNull('participant_id')
                ->lockForUpdate()
                ->first();

            if (!$availableCoupon) {
                throw new Exception('Mohon maaf, kupon undian telah habis!');
            }


            $participant->update([
                'foto'         => basename($uploadedPath),
                'status_hadir' => 'Hadir',
                'latitude'     => $this->userLat,
                'longitude'    => $this->userLng,
            ]);


            $availableCoupon->update([
                'participant_id' => $participant->id
            ]);

            return $availableCoupon->kode_kupon;
        });
    }

    private function handleSuccess($couponCode)
    {
        $throttleKey = 'claim-coupon:' . request()->ip();
        RateLimiter::clear($throttleKey);

        session()->flash('success', 'Berhasil! Kode Kupon Anda: ' . $couponCode);
        session(['current_participant_nip' => $this->detailData['nip']]);

        return redirect()->route('halamanKupon');
    }

    private function handleFailure(Exception $e, $uploadedPath)
    {
        if ($uploadedPath && Storage::disk('public')->exists($uploadedPath)) {
            Storage::disk('public')->delete($uploadedPath);
        }

        Log::error("Gagal Klaim Kupon [NIP: {$this->nip}]: " . $e->getMessage());

        $msg = $e->getMessage();
        // Sembunyikan pesan teknis database deadlock
        if (str_contains($msg, 'lock') || str_contains($msg, 'Deadlock') || str_contains($msg, 'Serialization failure')) {
            $msg = "Sistem sedang sibuk, silakan coba tekan tombol lagi.";
        }

        $this->addError('system', $msg);
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
