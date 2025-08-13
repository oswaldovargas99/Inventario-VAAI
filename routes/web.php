<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin', fn () => 'Área Admin')->name('admin.home');
    });

    Route::middleware('permission:aprobar movimientos')->group(function () {
        Route::get('/patrimonio/aprobaciones', fn () => 'Aprobaciones Patrimonio')
            ->name('patrimonio.aprobaciones');
    });

    Route::middleware('permission:vobo movimientos')->group(function () {
        Route::get('/secretaria/vobo', fn () => 'VoBo Secretaría')
            ->name('secretaria.vobo');
    });
});
