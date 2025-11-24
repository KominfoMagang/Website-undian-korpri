<?php

use App\Livewire\SlotMachine\Doorprize;
use Illuminate\Support\Facades\Route;

Route::name('slot-machine.')->group(function(){
    Route::get('undian', Doorprize::class)->name('undian');
});