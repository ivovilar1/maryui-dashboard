<?php

use App\Livewire\Auth\Login;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

//region Login Flow
Route::get('/login', Login::class)->name('login');
//endregion

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');
});
