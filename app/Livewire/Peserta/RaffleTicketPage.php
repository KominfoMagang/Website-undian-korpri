<?php

namespace App\Livewire\Peserta;

use Livewire\Attributes\Layout;
use Livewire\Component;

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
        $filePath = public_path('static/images/kupon-template.jpg'); 

        if (!file_exists($filePath)) {
            abort(404, 'Template kupon tidak ditemukan.');
        }

        $filename = 'kupon-undian-' . ($this->couponNumber ?? 'template') . '.jpg';

        return response()->download($filePath, $filename);
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
