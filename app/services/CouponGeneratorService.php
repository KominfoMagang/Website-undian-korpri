<?php

namespace App\Services;

use Exception;
use GdImage;
use Illuminate\Support\Facades\File;

class CouponGeneratorService
{
    // Konstanta Path Asset
    private const TEMPLATE_PATH = 'static/images/Template-coupon.png';
    private const FONT_BOLD     = 'fonts/Inter_28pt-SemiBold.ttf';
    private const FONT_REGULAR  = 'fonts/Inter_18pt-Regular.ttf';

    public function generate(string $name, string $nip, string $couponNumber)
    {
        $this->validateAssets();

        $imagePath = public_path(self::TEMPLATE_PATH);
        
        // Validasi apakah file gambar valid sebelum dimuat
        if (!file_exists($imagePath)) {
             throw new Exception('File template tidak ditemukan di path: ' . $imagePath);
        }

        $image = imagecreatefrompng($imagePath);

        if (!$image instanceof GdImage) {
            throw new Exception('Gagal memuat template gambar.');
        }

        $this->applyTextToImage($image, $name, $nip, $couponNumber);

        $filePath = $this->saveImage($image);
        
        // Bersihkan memory image utama
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

    private function applyTextToImage(GdImage $image, string $name, string $nip, string $couponNumber)
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

    // ---- KODE KUPON (tanpa drawCenteredText) ----
    imagettftext(
        $image,
        90,                    // ukuran besar
        0,                     // tanpa rotasi
        (int)($width * 0.30),  // posisi kiri sama dengan nama/nip
        (int)($height * 0.35), // sedikit di atas nama
        $colorGold,
        $fontBold,
        $couponNumber
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


    private function saveImage(GdImage $image): string
    {
        $tempDir = storage_path('app/public/generated-coupons');

        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $filename = 'kupon-' . uniqid() . '.jpg';
        $path = $tempDir . '/' . $filename;

        // Simpan kualitas 100
        if (!imagejpeg($image, $path, 100)) {
            throw new Exception('Gagal menyimpan file gambar.');
        }

        return $path;
    }
}