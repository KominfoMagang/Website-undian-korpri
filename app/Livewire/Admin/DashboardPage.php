<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use App\Models\Participant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard Admin')]
class DashboardPage extends Component
{
    
    public function render()
    {
        $stats = [
            'total'=> Participant::count(),
            'activeCoupon' => Coupon::where('status_kupon', 'Aktif')->count()
        ];

        return view('livewire.admin.dashboard-page',[
            'stats'=>$stats
        ]);
    }
}
