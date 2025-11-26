<?php

namespace App\Jobs;

use App\Models\Coupon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCouponsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue,Queueable, SerializesModels;

    public $quantity;

    /**
     * Create a new job instance.
     */
    public function __construct($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $generatedCount = 0;
        $batchSize = 2000;
        $dataToInsert = [];
        $now = now(); 

        while ($generatedCount < $this->quantity) {
            // Generate kode kupon 6 digit
            $code = str_pad(mt_rand(0,999999), 6 , '0', STR_PAD_LEFT);

            $dataToInsert[$code] = [
                'kode_kupon' => $code,
                'created_at'     => $now,
                'updated_at'     => $now, 
            ];

            $remainingNeeded = $this->quantity - $generatedCount;

             if (count($dataToInsert) >= $batchSize || count($dataToInsert) >= $remainingNeeded) {
                
                $inserted = Coupon::insertOrIgnore(array_values($dataToInsert));
                $generatedCount += $inserted;
                $dataToInsert = [];
            }
        }
    }
}
