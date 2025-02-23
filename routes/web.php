<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::get('globe', \App\Livewire\Globe::class)->name('globe');
    Route::get('assets', \App\Livewire\Assets::class)->name('assets');

    Route::get('pipelines/{pipeline}', \App\Livewire\ShowPipeline::class)->name('pipelines.show');
    Route::get('assets/{asset}', \App\Livewire\ShowAsset::class)->name('assets.show');
    Route::get('vessels/{vessel}', \App\Livewire\ShowVessel::class)->name('vessels.show');
    Route::get('pois/{poi}', \App\Livewire\ShowPOI::class)->name('pois.show');
});

require __DIR__.'/auth.php';
