<?php

use App\Livewire\Peserta\PresencePage;
use App\Livewire\Peserta\RaffleTicketPage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// PresencePage adalah halaman login
Route::get('/', PresencePage::class)->name('HalamanPresensi');
Route::get('/halaman-kupon', RaffleTicketPage::class)->name('halamanKupon');


// routes/web.php
Route::get('/test-gd', function() {
    if (!extension_loaded('gd')) {
        return 'GD extension not loaded';
    }
    
    $info = gd_info();
    
    return [
        'gd_version' => $info['GD Version'],
        'freetype_support' => $info['FreeType Support'] ?? false,
        'functions' => [
            'imageftbbox' => function_exists('imageftbbox'),
            'imagettftext' => function_exists('imagettftext'),
            'imagecreatefrompng' => function_exists('imagecreatefrompng'),
        ]
    ];
});

require __DIR__ . '/admin.php';
require __DIR__ . '/reward-system.php';
