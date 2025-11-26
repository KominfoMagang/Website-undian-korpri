<?php

namespace App\Livewire\Peserta;

use App\Models\Participant;
use App\Services\CouponGeneratorService;
use Exception;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.pages-peserta.kupon-undian')]
class RaffleTicketPage extends Component
{
    public array $banners = [
        [
            'id'    => 1,
            'image' => 'https://cdn.pixabay.com/photo/2022/10/28/03/48/hajj-7552281_960_720.jpg',
            'title' => 'Hadiah Utama: Paket Umroh'
        ],
        [
            'id'    => 2,
            'image' => 'https://cdn.pixabay.com/photo/2017/01/25/18/07/mobil-car-2008574_1280.jpg',
            'title' => 'Grand Prize: Mobil Keluarga'
        ],
    ];

    public ?string $couponNumber = null;
    public string $statusCoupon = 'Belum Ada';
    public array $detailData = [];

    public function mount()
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
            'fotoSelfie' => $participant->foto ? asset('storage/photos/' . $participant->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($participant->nama),

            // Tampilkan foto dari amazon S3
            // 'fotoSelfie' => $participant->foto
            //     ? Storage::disk('s3')->url($participant->foto)
            //     : 'https://ui-avatars.com/api/?name=' . urlencode($participant->nama),

        ];
        $userCoupon = $participant->coupons->first();

        if ($userCoupon) {
            $this->couponNumber = $userCoupon->kode_kupon;
            $this->statusCoupon = $userCoupon->status_kupon;
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
                unitKerja: $this->detailData['unit_kerja'],
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

    // Helper method untuk readability
    private function isCouponInvalid(): bool
    {
        return empty($this->detailData) ||
            !$this->couponNumber ||
            $this->couponNumber === '-';
    }

    public function render()
    {
        return view('livewire.peserta.raffle-ticket-page');
    }
}
