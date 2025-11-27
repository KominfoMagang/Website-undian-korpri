<?php

namespace App\Livewire\Admin;

use App\Exports\WinnersExport;
use App\Models\Coupon;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.admin')]
#[Title('Dashboard Admin')]

class DashboardPage extends Component
{
    public function exportExcel()
    {
        return Excel::download(new WinnersExport, 'data-pemenang-undian.xlsx');
    }

    public function render()
    {
        $stats = [
            'total' => Participant::count(),
            'activeCoupon' => Coupon::where('status_kupon', 'Aktif')->count()
        ];

        return view('livewire.admin.dashboard-page', [
            'stats' => $stats
        ]);
    }
}
