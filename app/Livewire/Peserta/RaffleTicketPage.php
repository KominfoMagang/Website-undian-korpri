<?php

namespace App\Livewire\Peserta;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

class RaffleTicketPage extends Component
{
    #[Layout('components.layouts.pages-peserta.kupon-undian')]

    public $banners = [];
    public $couponNumber;
    public $detailData = [];

    public function mount()
    {
        // Dummy banner doorprize
        $this->banners = [
            [
                'id' => 1,
                'image' => 'https://cdn.pixabay.com/photo/2022/10/28/03/48/hajj-7552281_960_720.jpg',
                'title' => 'Doorprize Banner 1'
            ],
            [
                'id' => 2,
                'image' => 'https://cdn.pixabay.com/photo/2017/01/25/18/07/mobil-car-2008574_1280.jpg',
                'title' => 'Doorprize Banner 2'
            ],
            [
                'id' => 3,
                'image' => 'https://images3.alphacoders.com/132/thumb-1920-1323165.png',
                'title' => 'Doorprize Banner 3'
            ],
        ];

        $this->couponNumber = '20056';
        $this->detailData = [
            'nama'       => 'John Doe',
            'nip'        => '123456789012345678',
            'unit_kerja' => 'Dinas Pendidikan',
        ];
    }

    public function downloadCoupon()
    {
        $name         = $this->detailData['nama']       ?? 'John Doe';
        $nip          = $this->detailData['nip']        ?? '123456789012345678';
        $unitKerja    = $this->detailData['unit_kerja'] ?? 'Dinas Pendidikan';
        $couponNumber = $this->couponNumber             ?? 'KORPRI-2025-00001';

        $filePath = $this->generateCouponImage($name, $nip, $unitKerja, $couponNumber);

        $downloadName = 'kupon-undian-' . Str::slug($couponNumber) . '.jpg';

        return response()->download($filePath, $downloadName)->deleteFileAfterSend(true);
    }

    // =========================
    // HELPER GD DI BAWAH INI
    // =========================

    private function generateCouponImage(string $name, string $nip, string $unitKerja, string $couponNumber): string
    {
        $templatePath = public_path('static/images/Template-coupon.png');
        $fontBold     = public_path('fonts/Inter_28pt-SemiBold.ttf');
        $fontRegular  = public_path('fonts/Inter_18pt-Regular.ttf');

        if (! file_exists($templatePath)) {
            throw new \Exception('Template kupon tidak ditemukan: ' . $templatePath);
        }

        if (! file_exists($fontBold)) {
            throw new \Exception('Font tidak ditemukan: ' . $fontBold);
        }

        $image = imagecreatefrompng($templatePath);

        $textColorDark = imagecolorallocate($image, 40, 40, 40);
        $textColorBlue = imagecolorallocate($image, 30, 91, 216);

        $width  = imagesx($image);
        $height = imagesy($image);

        $fontSizeName   = 20;
        $fontSizeNip    = 16;
        $fontSizeUnit   = 16;
        $fontSizeCoupon = 24;

        $yCoupon = (int) ($height * 0.30);
        $yName   = (int) ($height * 0.45);
        $yNip    = (int) ($height * 0.55);
        $yUnit   = (int) ($height * 0.65);

        $this->drawCenteredText($image, $couponNumber, $fontSizeCoupon, 0, $yCoupon, $textColorBlue, $fontBold, $width);
        $this->drawCenteredText($image, $name,         $fontSizeName,   0, $yName,   $textColorDark, $fontBold,  $width);
        $this->drawCenteredText($image, $nip,          $fontSizeNip,    0, $yNip,    $textColorDark, $fontRegular ?: $fontBold, $width);
        $this->drawCenteredText($image, $unitKerja,    $fontSizeUnit,   0, $yUnit,   $textColorDark, $fontRegular ?: $fontBold, $width);

        $tempDir = storage_path('app/tmp');
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $filePath = $tempDir . '/kupon-' . uniqid() . '.jpg';
        imagejpeg($image, $filePath, 90);
        imagedestroy($image);

        return $filePath;
    }

    private function drawCenteredText($image, string $text, int $fontSize, int $angle, int $y, $color, string $fontPath, int $imageWidth): void
    {
        $bbox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $x = (int) (($imageWidth - $textWidth) / 2);

        imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontPath, $text);
    }

    public function render()
    {
        return view('livewire.peserta.raffle-ticket-page', [
            'banners'      => $this->banners,
            'couponNumber' => $this->couponNumber,
            'detailData'   => $this->detailData,
        ]);
    }
}
