<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Sample / showcase pages (component reference).
    Route::controller(SampleController::class)->prefix('samples')->name('samples.')->group(function () {
        Route::get('/table', 'table')->name('table');
        Route::get('/form', 'form')->name('form');
        Route::get('/components', 'components')->name('components');
    });

    // Access control — RBAC demo pages, gated by permission middleware.
    Route::controller(AccessController::class)->prefix('access')->name('access.')->group(function () {
        Route::get('/roles', 'roles')->middleware('permission:users.view')->name('roles');
        Route::get('/activity', 'activity')->middleware('permission:activity.view')->name('activity');
    });

    // Region / address autocomplete.
    Route::get('/regions/search', [RegionController::class, 'search'])->name('regions.search');
    Route::view('/samples/region', 'samples.region')->name('samples.region');
});

require __DIR__.'/auth.php';
