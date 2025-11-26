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

    /**
     * Generate gambar kupon
     */
    public function generate(string $name, string $nip, string $unitKerja, string $couponNumber): string
    {
        $this->validateAssets();

        $imagePath = public_path(self::TEMPLATE_PATH);

        // PHP 8+: Fungsi ini mengembalikan object GdImage, bukan resource.
        $image = imagecreatefrompng($imagePath);

        if (!$image) {
            throw new Exception('Gagal memuat template gambar.');
        }

        // Tidak perlu try-finally/imagedestroy di PHP 8.0+ untuk GdImage object.
        // Object akan otomatis di-cleanup oleh Garbage Collector saat scope fungsi berakhir.

        $this->applyTextToImage($image, $name, $nip, $unitKerja, $couponNumber);

        return $this->saveImage($image);
    }

    /**
     * Validasi keberadaan file aset sebelum memproses
     */
    private function validateAssets(): void
    {
        if (!file_exists(public_path(self::TEMPLATE_PATH))) {
            throw new Exception('Template gambar tidak ditemukan.');
        }
        if (!file_exists(public_path(self::FONT_BOLD))) {
            throw new Exception('Font Bold tidak ditemukan.');
        }
    }

    /**
     * Logika visual / tipografi
     */
    private function applyTextToImage(GdImage $image, string $name, string $nip, string $unitKerja, string $couponNumber): void
    {
        // 1. Definisikan Warna
        // Warna Teks Biasa (Abu Gelap - #333333)
        $colorDark = imagecolorallocate($image, 51, 51, 51);

        // Warna Kode Kupon (Biru Elegan - #1E40AF - Tailwind Blue 800)
        // Agar kontras dan terlihat "Mahal"
        $colorCoupon = imagecolorallocate($image, 30, 64, 175);

        // 2. Setup Dimensi & Font
        $width  = imagesx($image);
        $height = imagesy($image); // Asumsi tinggi template sekitar 600-800px

        $fontBold    = public_path(self::FONT_BOLD);
        $fontRegular = public_path(self::FONT_REGULAR);

        // Fallback font
        if (!file_exists($fontRegular)) {
            $fontRegular = $fontBold;
        }

        // 3. Atur Posisi (Typography Hierarchy)
        // Kita atur posisi Y berdasarkan persentase agar responsif terhadap ukuran template,
        // Tapi kita bedakan ukuran font agar ada hierarki visual.

        // --- A. KODE KUPON (Level 1: Paling Menonjol) ---
        // Font size: 42 (Sangat Besar)
        $this->drawCenteredText(
            image: $image,
            text: $couponNumber,
            fontSize: 42,
            y: (int) ($height * 0.32), // Posisi agak ke atas
            color: $colorCoupon,
            fontPath: $fontBold,
            imageWidth: $width
        );

        // --- B. NAMA PESERTA (Level 2: Identitas Utama) ---
        // Font size: 22 (Besar tapi di bawah kupon)
        $this->drawCenteredText(
            image: $image,
            text: strtoupper($name), // Nama di-uppercase agar lebih rapi
            fontSize: 22,
            y: (int) ($height * 0.48),
            color: $colorDark,
            fontPath: $fontBold,
            imageWidth: $width
        );

        // --- C. NIP (Level 3: Metadata) ---
        // Font size: 16 (Sedang)
        $this->drawCenteredText(
            image: $image,
            text: 'NIP: ' . $nip, // Tambahkan label 'NIP' agar jelas
            fontSize: 16,
            y: (int) ($height * 0.56),
            color: $colorDark,
            fontPath: $fontRegular,
            imageWidth: $width
        );

        // --- D. UNIT KERJA (Level 4: Metadata Tambahan) ---
        // Font size: 16 (Sedang)
        $this->drawCenteredText(
            image: $image,
            text: $unitKerja,
            fontSize: 16,
            y: (int) ($height * 0.63),
            color: $colorDark,
            fontPath: $fontRegular,
            imageWidth: $width
        );
    }

    /**
     * Helper untuk menggambar teks rata tengah
     */
    private function drawCenteredText(GdImage $image, string $text, int $fontSize, int $y, int $color, string $fontPath, int $imageWidth): void
    {
        // Hitung bounding box teks
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);

        if ($bbox === false) {
            return;
        }

        // Rumus mencari titik X agar Center
        // $bbox[2] adalah kanan bawah, $bbox[0] adalah kiri bawah
        $textWidth = abs($bbox[2] - $bbox[0]);
        $x = (int) (($imageWidth - $textWidth) / 2);

        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
    }

    /**
     * Simpan file ke storage
     */
    private function saveImage(GdImage $image): string
    {
        $tempDir = storage_path('app/tmp');

        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $filePath = $tempDir . '/kupon-' . uniqid() . '.jpg';

        // Simpan dengan kualitas 90 (High Quality JPEG)
        if (!imagejpeg($image, $filePath, 90)) {
            throw new Exception('Gagal menyimpan file gambar sementara.');
        }

        return $filePath;
    }
}
