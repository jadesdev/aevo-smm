<?php

/*
|--------------------------------------------------------------------------
| Install Routes
|--------------------------------------------------------------------------
|
| This route is responsible for handling the installation process
*/

use App\Http\Controllers\InstallController;

Route::get('/', [InstallController::class, 'index'])->name('index');

Route::controller(InstallController::class)->prefix('install')->as('install.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/requirement', 'requirement')->name('requirement');

    Route::get('/database', 'database')->name('database.show');
    Route::post('/database', 'environment')->name('database.save');
    Route::post('/test-database', 'testDatabase')->name('test.database');

    Route::get('/settings', 'setting')->name('settings.show');
    Route::post('/complete', 'complete')->name('settings.save');
});