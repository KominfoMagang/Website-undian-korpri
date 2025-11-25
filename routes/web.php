<?php

use App\Livewire\Peserta\PresencePage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', PresencePage::class);

Route::get('/admin/login', function () {
    return view('auth.login_admin');
})->name('admin.login');

Route::get('/admin/test', function () {
    return view('livewire.admin.dashboard-page'); 
});
