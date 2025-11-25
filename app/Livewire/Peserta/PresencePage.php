<?php

namespace App\Livewire\Peserta;

use App\Models\Coupon;
use App\Models\Participant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PresencePage extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.pages-peserta.peserta')]
    #[Title("Halaman Absensi peserta")]

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
    public $centerLat = -7.316538442400661;
    public $centerLng = 108.19675248829186;
    public $radiusMeters = 500;

    public function updated($propertyName)
    {
        if ($propertyName === 'nip') {
            $this->resetState();
            $this->nip = preg_replace('/[^0-9]/', '', $this->nip);
            if (strlen($this->nip) >= 5) {
                $this->validateNip();
            }
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
        // 1. Cari Peserta berdasarkan NIP di Database
        $participant = Participant::where('nip', $this->nip)->first();

        if ($participant) {
            if ($participant->coupons()->exists()) {
                $this->showDetails = false;
                $this->errorMessage = 'Peserta dengan NIP ini sudah melakukan presensi dan memiliki kupon!';
                return;
            }

            // 3. Jika belum absen, tampilkan detail
            $this->showDetails = true;
            $this->errorMessage = '';

            $this->detailData = [
                'id'         => $participant->id,
                'nama'       => $participant->nama,
                'nip'        => $participant->nip,
                'unit_kerja' => $participant->unit_kerja
            ];
        } else {
            $this->showDetails = false;
            $this->errorMessage = 'NIP tidak ditemukan dalam database peserta!';
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
            $this->locationErrorMessage = 'Anda berada di luar area acara (' . round($distance) . ' meter). Silakan mendekat ke lokasi.';
            $this->dispatch('location-radius-error');
        }
    }

    public function locationFailed($code)
    {
        $this->locationGranted = false;
        $errorMessages = [
            1 => 'Akses lokasi ditolak. Mohon izinkan akses lokasi di browser Anda.',
            2 => 'Posisi tidak tersedia. Pastikan GPS aktif.',
            3 => 'Waktu permintaan lokasi habis. Silakan coba lagi.'
        ];
        $this->locationErrorMessage = $errorMessages[$code] ?? 'Error lokasi tidak diketahui.';
        $this->dispatch('location-system-error');
    }

    private function calculateDistanceMeters($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        $a = sin($latDelta / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function klaimKupon()
    {
        // --- 1. Validasi Awal (Tetap sama) ---
        if (!$this->locationGranted) {
            $this->addError('location', 'Posisi Anda belum terverifikasi di area acara.');
            return;
        }

        if (!$this->agreement) {
            $this->addError('agreement', 'Anda harus menyetujui pernyataan kebenaran data.');
            return;
        }

        $this->validate([
            'photo' => 'required|image|max:2048'
        ], [
            'photo.required' => 'Foto selfie wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        // --- 2. Proses Utama ---
        if ($this->showDetails && isset($this->detailData['id'])) {

            DB::beginTransaction(); // Mulai Transaksi

            try {
                $participant = Participant::findOrFail($this->detailData['id']);

                // Cek apakah sudah punya kupon (double check)
                if ($participant->coupons()->exists()) {
                    $this->addError('system', 'Maaf, NIP ini baru saja melakukan klaim.');
                    DB::rollBack();
                    return;
                }

                // A. Simpan Foto & Update Peserta
                $filename = 'presensi_' . $participant->nip . '_' . time() . '.' . $this->photo->getClientOriginalExtension();
                $path = $this->photo->storeAs('selfies', $filename, 'public');

                $participant->update([
                    'foto'         => $path,
                    'status_hadir' => 'Hadir',
                    'latitude'     => $this->userLat,
                    'longitude'    => $this->userLng,
                ]);

                // B. GENERATE KUPON (BAGIAN ANTI BENTROK)
                $inserted = false;
                $attempts = 0;
                $kodeKupon = null; // Inisialisasi variabel

                do {
                    try {
                        // 1. Acak angka
                        $kodeKupon = mt_rand(100000, 999999);

                        // 2. Coba Insert langsung (Tanpa Cek Exists)
                        $participant->coupons()->create([
                            'kode_kupon'   => $kodeKupon,
                            'status_kupon' => 'Aktif'
                        ]);

                        // 3. Jika baris ini tereksekusi, berarti BERHASIL (tidak duplikat)
                        $inserted = true;
                    } catch (QueryException $e) {
                        // Cek apakah errornya karena Duplicate Entry (Code 1062 di MySQL)
                        if ($e->errorInfo[1] == 1062) {
                            $attempts++;
                            // Jika sudah mencoba 5x masih gagal (sial banget), stop biar gak loading terus
                            if ($attempts >= 5) {
                                throw new \Exception("Gagal generate kode unik setelah 5x percobaan. Silakan coba lagi.");
                            }
                            // Ulangi loop (continue)
                            continue;
                        } else {
                            // Jika error lain (bukan duplikat), lempar error asli
                            throw $e;
                        }
                    }
                } while (!$inserted);

                // --- 3. Finalisasi ---
                DB::commit();

                session()->flash('success', 'Berhasil! Kode Kupon Anda: ' . $kodeKupon);
                session(['current_participant_nip' => $participant->nip]);

                return redirect()->route('halamanKupon');
            } catch (\Exception $e) {
                DB::rollBack();

                // Hapus foto jika database gagal
                if (isset($path)) {
                    Storage::disk('public')->delete($path);
                }

                // Log error asli untuk developer (opsional)
                // \Log::error($e->getMessage());

                $this->addError('system', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            }
        }
    }
    public function render()
    {
        return view('livewire.peserta.presence-page');
    }
}
