<?php

namespace App\services;

use Exception;
use GdImage;
use Illuminate\Support\Facades\File;

class CouponGeneratorService
{
    // Konstanta Path Asset
    private const TEMPLATE_PATH = 'static/images/Template-coupon.png';
    private const FONT_BOLD     = 'fonts/Inter_28pt-SemiBold.ttf';
    private const FONT_REGULAR  = 'fonts/Inter_18pt-Regular.ttf';

    public function generate(string $name, string $nip, string $unitKerja, string $couponNumber)
    {
        $this->validateAssets();

        $imagePath = public_path(self::TEMPLATE_PATH);
        $image = imagecreatefrompng($imagePath);

        if (!$image instanceof GdImage) {
            throw new Exception('Gagal memuat template gambar.');
        }

        $this->applyTextToImage($image, $name, $nip, $unitKerja, $couponNumber);

        $filePath = $this->saveImage($image);
        unset($image);

        return $filePath;
    }

    private function validateAssets(): void
    {
        if (!file_exists(public_path(self::TEMPLATE_PATH))) {
            throw new Exception('Template gambar tidak ditemukan.');
        }

        if (
            !file_exists(public_path(self::FONT_BOLD)) &&
            !file_exists(public_path(self::FONT_REGULAR))
        ) {
            throw new Exception('Font tidak ditemukan.');
        }
    }

    private function applyTextToImage(GdImage $image, string $name, string $nip, string $unitKerja, string $couponNumber)
    {
        // Colors
        $colorWhite = imagecolorallocate($image, 255, 255, 255);
        $colorGold  = imagecolorallocate($image, 225, 178, 55);

        // Dimensions
        $width  = imagesx($image);
        $height = imagesy($image);

        // Fonts
        $fontBold    = public_path(self::FONT_BOLD);
        $fontRegular = file_exists(public_path(self::FONT_REGULAR))
            ? public_path(self::FONT_REGULAR)
            : $fontBold;

        // ---- KODE KUPON (center) ----
        $this->drawCenteredText(
            $image,
            $couponNumber,
            90,
            (int) ($height * 0.35),
            $colorGold,
            $fontBold,
            $width
        );

        // Margin kiri untuk nama & NIP
        $leftMarginX = (int) ($width * 0.30);

        // ---- NAMA PESERTA ----
        imagettftext(
            $image,
            35,
            0,
            $leftMarginX,
            (int) ($height * 0.52),
            $colorWhite,
            $fontBold,
            strtoupper($name)
        );

        // ---- NIP ----
        imagettftext(
            $image,
            35,
            0,
            $leftMarginX,
            (int) ($height * 0.65),
            $colorWhite,
            $fontBold,
            $nip
        );
    }

    private function drawCenteredText(
        GdImage $image,
        string $text,
        int $fontSize,
        int $y,
        int $color,
        string $fontPath,
        int $imageWidth
    ): void {
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
        if ($bbox === false) {
            return;
        }

        $textWidth = abs($bbox[2] - $bbox[0]);

        // Center horizontal
        $x = (int) (($imageWidth - $textWidth) / 1.6);

        imagettftext(
            $image,
            $fontSize,
            0,
            $x,
            $y,
            $color,
            $fontPath,
            $text
        );
    }

    private function saveImage(GdImage $image): string
    {
        $tempDir = storage_path('app/public/generated-coupons');

        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $filename = 'kupon-' . uniqid() . '.jpg';
        $path = $tempDir . '/' . $filename;

        if (!imagejpeg($image, $path, 100)) {
            throw new Exception('Gagal menyimpan file gambar.');
        }

        return $path;
    }
}
