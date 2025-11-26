<?php

use App\Livewire\RewardSystem\Doorprize;
use App\Livewire\RewardSystem\Participant;
use App\Livewire\RewardSystem\Winner;
use Illuminate\Support\Facades\Route;

Route::name('slot-machine.')->group(function(){
    Route::get('undian', Doorprize::class)->name('undian');
    Route::get('daftar-pemenang', Winner::class)->name('pemenang');
    Route::get('daftar-peserta', Participant::class)->name('peserta');
});