<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/dasbor', 'dashboard')->name('dashboard');
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

    // WhatsApp module.
    Route::controller(WhatsAppController::class)->prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/send', 'send')->name('send');
    });

    // Import / Export.
    Route::get('/exports/members/{format}', [ExportController::class, 'members'])->name('exports.members');
    Route::get('/samples/import', [ExportController::class, 'importForm'])->name('samples.import');
    Route::post('/samples/import', [ExportController::class, 'importStore'])->name('samples.import.store');

    // Notifications.
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'read')->name('read');
        Route::post('/read-all', 'readAll')->name('readAll');
        Route::post('/send-demo', 'sendDemo')->name('sendDemo');
    });
});

require __DIR__.'/auth.php';
