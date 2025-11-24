<?php

use App\Livewire\SlotMachine\Doorprize;
use App\Livewire\SlotMachine\Winner;
use Illuminate\Support\Facades\Route;

Route::name('slot-machine.')->group(function(){
    Route::get('undian', Doorprize::class)->name('undian');
    Route::get('daftar-pemenang', Winner::class)->name('pemenang');
});