<?php

use App\Http\Controllers\SampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/settings', 'settings.index')->name('settings');

    // Sample / showcase pages (component reference).
    Route::controller(SampleController::class)->prefix('samples')->name('samples.')->group(function () {
        Route::get('/table', 'table')->name('table');
        Route::get('/form', 'form')->name('form');
        Route::get('/components', 'components')->name('components');
    });
});

require __DIR__.'/auth.php';
