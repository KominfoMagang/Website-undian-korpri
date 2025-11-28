<?php

namespace App\Livewire\Peserta;

use App\Models\Participant;
use App\services\CouponGeneratorService;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.Pages-peserta.kupon-undian')]
#[Title("Halaman Kupon")]

class RaffleTicketPage extends Component
{
    public array $banners = [];
    public ?string $couponNumber = null;
    public string $statusCoupon = 'Belum Ada';
    public array $detailData = [];

    public function mount()
    {
        $this->loadDoorprizeBanners();
        $this->loadParticipantData();
    }

    private function loadDoorprizeBanners()
    {
        $directory = public_path('static/doorprizes');
        $files = File::files($directory);

        $this->banners = [];
        $id = 1;

        foreach ($files as $file) {
            $filename = $file->getFilename();

            $this->banners[] = [
                'id'    => $id,
                'image' => 'static/doorprizes/' . $filename,
                'title' => pathinfo($filename, PATHINFO_FILENAME),
            ];

            $id++;
        }
    }

    private function loadParticipantData()
    {
        $nip = session('current_participant_nip');

        if (!$nip) {
            return $this->redirectRoute('HalamanPresensi');
        }

        $participant = cache()->remember(
            'participant_' . $nip,
            10,
            fn() => Participant::with('coupons')->where('nip', $nip)->first()
        );

        if (!$participant) {
            session()->flash('error', 'Data peserta tidak ditemukan.');
            return $this->redirectRoute('HalamanPresensi');
        }

        $this->detailData = [
            'nama'       => $participant->nama,
            'nip'        => $participant->nip,
            'unit_kerja' => $participant->unit_kerja,
            'fotoSelfie' => $participant->foto
                ? Storage::disk('s3')->temporaryUrl(
                    'photos/' . $participant->foto,
                    now()->addDays(2)
                )
                : 'https://ui-avatars.com/api/?name=' . urlencode($participant->nama),
            // 'fotoSelfie' => $participant->foto
            //     ? asset('storage/photos/' . $participant->foto)
            //     : 'https://ui-avatars.com/api/?name=' . urlencode($participant->nama),

        ];

        $coupon = $participant->coupons->first();

        if ($coupon) {
            $this->couponNumber = $coupon->kode_kupon;
            $this->statusCoupon = $coupon->status_kupon;
        } else {
            $this->couponNumber = '-';
        }
    }

    public function downloadCoupon(CouponGeneratorService $generatorService)
    {
        if ($this->isCouponInvalid()) {
            $this->dispatch('alert', type: 'error', message: 'Data kupon tidak valid atau belum tersedia.');
            return;
        }

        try {
            $filePath = $generatorService->generate(
                name: $this->detailData['nama'],
                nip: $this->detailData['nip'],
                couponNumber: $this->couponNumber
            );

            $fileName = sprintf(
                'kupon-undian-%s-%s.jpg',
                Str::slug($this->detailData['nama']),
                $this->couponNumber
            );

            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            $this->dispatch('alert', type: 'error', message: 'Gagal mendownload kupon, silakan coba lagi nanti.');
        }
    }

    private function isCouponInvalid(): bool
    {
        return empty($this->detailData)
            || !$this->couponNumber
            || $this->couponNumber === '-';
    }

    public function logout()
    {
        session()->forget('current_participant_nip');
        if (isset($this->detailData['nip'])) {
            cache()->forget('participant_' . $this->detailData['nip']);
        }

        return $this->redirectRoute('HalamanPresensi');
    }

    public function render()
    {
        return view('livewire.peserta.raffle-ticket-page');
    }
}
