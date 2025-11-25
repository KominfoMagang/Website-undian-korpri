<?php

namespace App\Livewire\Peserta;

use App\Models\Participant;
use App\Models\Winner;
use Exception;
use GdImage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

class RaffleTicketPage extends Component
{
    #[Layout('components.layouts.pages-peserta.kupon-undian')]
    public array $banners = [];
    public ?string $couponNumber = null;
    public string $statusCoupon = 'Aktif';
    public array $detailData = [];

    public function mount()
    {
        $nip = session('current_participant_nip');

        if (! $nip) {
            return redirect()->route('HalamanPresensi');
        }

        $participant = Participant::with('coupons')->where('nip', $nip)->first();

        if (! $participant) {
            session()->flash('error', 'Data peserta tidak ditemukan.');
            return redirect()->route('HalamanPresensi');
        }

        $this->detailData = [
            'nama'       => $participant->nama,
            'nip'        => $participant->nip,
            'unit_kerja' => $participant->unit_kerja,
        ];

        $userCoupon = $participant->coupons->first();

        if ($userCoupon) {
            $this->couponNumber = $userCoupon->kode_kupon;
            $this->statusCoupon = $userCoupon->status_kupon;
        } else {
            $this->couponNumber = '-';
            $this->statusCoupon = 'Belum Ada';
        }

        $this->banners = [
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
    }

    public function downloadCoupon()
    {
        if (empty($this->detailData) || ! $this->couponNumber || $this->couponNumber === '-') {
            $this->dispatch('alert', type: 'error', message: 'Data kupon tidak valid.');
            return;
        }

        try {
            $filePath = $this->generateCouponImage(
                $this->detailData['nama'],
                $this->detailData['nip'],
                $this->detailData['unit_kerja'],
                $this->couponNumber
            );

            $fileName = 'kupon-undian-' . Str::slug($this->detailData['nama']) . '-' . $this->couponNumber . '.jpg';

            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal mendownload kupon: ' . $e->getMessage());
        }
    }

    private function generateCouponImage(string $name, string $nip, string $unitKerja, string $couponNumber): string
    {
        $templatePath = public_path('static/images/Template-coupon.png');
        $fontBold     = public_path('fonts/Inter_28pt-SemiBold.ttf');
        $fontRegular  = public_path('fonts/Inter_18pt-Regular.ttf');

        if (! file_exists($templatePath)) {
            throw new Exception('Template gambar tidak ditemukan di: ' . $templatePath);
        }

        if (! file_exists($fontBold)) {
            throw new Exception('Font Bold tidak ditemukan di: ' . $fontBold);
        }

        $fontRegular = file_exists($fontRegular) ? $fontRegular : $fontBold;

        $image = imagecreatefrompng($templatePath);
        $colorDark = imagecolorallocate($image, 40, 40, 40);
        $colorBlue = imagecolorallocate($image, 30, 91, 216);

        $width  = imagesx($image);
        $height = imagesy($image);

        $this->drawCenteredText($image, $couponNumber, 24, (int) ($height * 0.30), $colorBlue, $fontBold, $width);
        $this->drawCenteredText($image, $name, 20, (int) ($height * 0.45), $colorDark, $fontBold, $width);
        $this->drawCenteredText($image, $nip, 16, (int) ($height * 0.55), $colorDark, $fontRegular, $width);
        $this->drawCenteredText($image, $unitKerja, 16, (int) ($height * 0.65), $colorDark, $fontRegular, $width);

        $tempDir = storage_path('app/tmp');
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $filePath = $tempDir . '/kupon-' . uniqid() . '.jpg';
        imagejpeg($image, $filePath, 90);
        imagedestroy($image);

        return $filePath;
    }

    private function drawCenteredText(GdImage $image, string $text, int $fontSize, int $y, int $color, string $fontPath, int $imageWidth): void
    {
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $x = (int) (($imageWidth - $textWidth) / 2);

        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
    }

    public function render()
    {
        return view('livewire.peserta.raffle-ticket-page');
    }
}
