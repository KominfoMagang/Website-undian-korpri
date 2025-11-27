<?php

namespace App\Exports;

use App\Models\Winner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WinnersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Winner::with([
            'participant',
            'coupon',
            'reward.category' // Relasi nested (Winner -> Reward -> Category)
        ])->get();
    }

    public function map($winner): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $winner->participant->nama ?? '-',
            $winner->participant->nip ? "'" . $winner->participant->nip : '-', // Tambah petik agar NIP tidak terpotong excel
            $winner->participant->unit_kerja ?? '-',
            $winner->coupon->kode_kupon ?? '-',
            $winner->reward->nama_hadiah ?? '-',
            $winner->reward->category->nama_kategori ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pemenang',
            'NIP',
            'Unit Kerja',
            'Kode Kupon',
            'Hadiah',
            'Kategori Hadiah',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
