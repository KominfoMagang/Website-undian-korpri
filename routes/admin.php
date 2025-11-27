<?php

use App\Livewire\Admin\CouponPage;
use App\Livewire\Admin\DashboardPage;
use App\Livewire\Admin\ParticipantPage;
use App\Livewire\Admin\RewardConfigPage;
use App\Livewire\Admin\StorePage;
use App\Livewire\Auth\LoginPage;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', LoginPage::class)->middleware('guest')->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth:web')->name('admin.')->group(function() {
    Route::get('dashboard', DashboardPage::class)->name('dashboard');
    Route::get('kupon', CouponPage::class)->name('coupon');
    Route::get('peserta', ParticipantPage::class)->name('participant');
    Route::get('kategori-dan-hadiah', RewardConfigPage::class)->name('reward-config');
    Route::get('toko', StorePage::class)->name('store');
});
