<?php

use App\Livewire\{Auth, Welcome};
use App\Livewire\Customers;
use Illuminate\Support\Facades\Route;

//region Login Flow
Route::get('/login', Auth\Login::class)->name('login');
Route::get('/logout', Auth\Logout::class)->name('auth.logout');
//endregion

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');

    //region Customers Flow
    Route::get('/customers', Customers\Index::class)->name('customers');
    //endregion
});
