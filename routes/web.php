<?php

use App\Livewire\Peserta\PresencePage;
use App\Livewire\Peserta\RaffleTicketPage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// PresencePage adalah halaman login
Route::get('/', PresencePage::class);

Route::get('/admin/login', function () {
    return view('auth.login_admin');
})->name('admin.login');

Route::get('/admin/test', function () {
    return view('livewire.admin.dashboard-page'); 
});
Route::get('/halaman-kupon', RaffleTicketPage::class)->name('halamanKupon');

require __DIR__ . '/slot-machine.php';
