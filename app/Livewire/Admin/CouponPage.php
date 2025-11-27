<?php

namespace App\Livewire\Admin;

use App\Jobs\GenerateCouponsJob;
use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Generate kupon undian')]

class CouponPage extends Component
{
    use WithPagination;
    public $amount = 100;
    protected $paginationTheme = 'bootstrap';

    public function generate()
    {
        // 1. Validasi Input
        $this->validate([
            'amount' => 'required|integer|min:1|max:50000'
        ]);
        set_time_limit(300);

        $quantityNeeded = $this->amount;
        $generatedCount = 0;
        $batchSize = 1000; // Jumlah insert per batch
        $dataToInsert = [];
        $now = now();
        
        while ($generatedCount < $quantityNeeded) {

            $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $dataToInsert[$code] = [
                'kode_kupon' => $code,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $remainingNeeded = $quantityNeeded - $generatedCount;
            if (count($dataToInsert) >= $batchSize || count($dataToInsert) >= $remainingNeeded) {
                $inserted = Coupon::insertOrIgnore(array_values($dataToInsert));
                $generatedCount += $inserted;
                $dataToInsert = [];
            }
        }

        // 4. Feedback ke User
        session()->flash('success', "Berhasil membuat {$generatedCount} kupon secara instan.");

        // 5. Reset Form
        $this->amount = 100;
    }

    // public function resetCoupons()
    // {
    //     Coupon::truncate();
    //     session()->flash('success', 'Semua data kupon berhasil dihapus.');
    // }

    public function render()
    {
        $coupons = Coupon::with('participant')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.coupon-page', [
            'coupons' => $coupons
        ]);
    }
}
