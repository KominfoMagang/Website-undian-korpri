<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function closeAndRedirect()
    {
        // 1. Update status absensi jadi 'tutup'
        Setting::updateOrCreate(
            ['key' => 'status_absensi'],
            ['value' => 'tutup']
        );

        // 2. Redirect ke halaman undian
        return redirect()->route('reward-system.undian');
    }
}
