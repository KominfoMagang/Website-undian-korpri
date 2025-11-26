<?php

namespace App\Livewire\Admin;

use App\Jobs\GenerateCouponsJob;
use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Generate kupon undian  ')]
class CouponPage extends Component
{
    use WithPagination;
    public $amount = 100;
    protected $paginationTheme = 'bootstrap';

    public function generate()
    {
        $this->validate([
            'amount'=> 'required|integer|min:1|max:50000'
        ]);

        GenerateCouponsJob::dispatch($this->amount);

        session()->flash('success', "Permintaan generate {$this->amount} kupon sedang diproses di latar belakang.");

        $this->amount = 100;
    }

    // public function resetCoupons()
    // {
    //     Coupon::truncate();
    //     session()->flash('success', 'Semua data kupon berhasil dihapus.');
    // }

    public function render()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(20);
        return view('livewire.admin.coupon-page', [
            'coupons' => $coupons
        ]);
    }
}
