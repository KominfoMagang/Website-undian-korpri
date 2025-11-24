<?php

use App\Livewire\Peserta\PresencePage;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', PresencePage::class);

require __DIR__ . '/slot-machine.php';
