<?php

namespace App\Exports;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as PhpSpreadsheetWorksheet;

class StoreExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Store::with([
            'coupons.participant'
        ])->get();
    }

    /**
    * Mengatur isi data per baris
    * @var Store $store
    */
    public function map($store): array
    {
        $kuponTerpakai = $store->coupons->filter(function ($coupon) {
            return $coupon->participant_id != null && $coupon->participant != null;
        });

        $listNama = $kuponTerpakai->map(function ($coupon) {
            return '- ' . $coupon->participant->nama . ' (' . $coupon->participant->nip . ')';
        })->implode("\n"); 

        return [
            $store->kode_toko,
            $store->nama_toko,
            $store->jenis_produk,
            $store->stok,
            $kuponTerpakai->count(),
            $listNama
        ];
    }

    /**
    * Judul Header Excel
    */
    public function headings(): array
    {
        return [
            'Kode Toko',
            'Nama Toko',
            'Jenis Produk',
            'Stok',
            'Jumlah Diklaim',
            'List Participant (Nama & NIP)',
        ];
    }

    /**
    * Mengatur Style Excel (Wrap Text)
    */
    public function styles(PhpSpreadsheetWorksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'F' => ['alignment' => ['wrapText' => true]],
            'A:F' => [
                'alignment' => [
                    'vertical' => StyleAlignment::VERTICAL_TOP,
                    'horizontal' => StyleAlignment::HORIZONTAL_LEFT,
                ]
            ],
        ];
    }
}