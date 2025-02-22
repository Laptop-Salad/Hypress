<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('globe', \App\Livewire\Globe::class)
    ->middleware(['auth'])
    ->name('globe');

require __DIR__.'/auth.php';
