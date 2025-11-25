<?php

use App\Livewire\Peserta\PresencePage;
use App\Livewire\Peserta\RaffleTicketPage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// PresencePage adalah halaman login
Route::get('/', PresencePage::class);
Route::get('/halaman-kupon', RaffleTicketPage::class)->name('halamanKupon');

require __DIR__ . '/slot-machine.php';
