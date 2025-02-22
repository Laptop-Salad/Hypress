<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::get('globe', \App\Livewire\Globe::class)->name('globe');
    Route::get('assets', \App\Livewire\Assets::class)->name('assets');
});

require __DIR__.'/auth.php';
