<?php

use App\Livewire\Admin\DashboardPage;
use App\Livewire\Auth\LoginPage;
use Illuminate\Support\Facades\Route;

Route::get('/login', LoginPage::class)->name('auth.login');

Route::prefix('admin')->group(function() {
    Route::get('dashboard', DashboardPage::class);
});
