<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Models\User;

Route::get('/', fn () => auth()->check() ? redirect()->route('inicio') : view('welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // ===== Inicio inteligente =====
    Route::get('/inicio', function () {
        /** @var User $u */
        $u = Auth::user();

        if ($u->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Aprobador o VoBo: Dashboard general (no admin)
        if ($u->can('aprobar movimientos') || $u->can('vobo movimientos')) {
            return redirect()->route('panel'); // <-- nuevo dashboard general
        }

        // Usuario general: Mi Inventario
        return redirect()->route('usuarios.dashboard');
    })->name('inicio');

    // ===== Alias opcional por compatibilidad (si algo antiguo llama /dashboard) =====
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
        ->middleware(['role:Admin'])
        ->name('dashboard');

    // ===== ADMIN =====
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'dashboard')->name('dashboard'); // dashboard para Admin

        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('dependencias', DependenciaController::class)->except(['show']);
    });

    // ===== Dashboard GENERAL (solo Aprobador/VoBo, NO usuarios) =====
    Route::middleware(['permission:aprobar movimientos|vobo movimientos'])->group(function () {
        Route::view('/panel', 'dashboard')->name('panel'); // usa misma vista de dashboard
    });

    // ===== Inventario (solo Aprobador/VoBo) =====
    Route::middleware(['permission:aprobar movimientos|vobo movimientos'])->group(function () {
        Route::view('/inventario-general', 'inventario.general')->name('inventario.general');
    });

    // ===== Aprobador =====
    Route::middleware(['permission:aprobar movimientos'])->group(function () {
        Route::view('/patrimonio/aprobaciones', 'patrimonio.aprobaciones')->name('patrimonio.aprobaciones');
    });

    // ===== VoBo =====
    Route::middleware(['permission:vobo movimientos'])->group(function () {
        Route::view('/secretaria/vobo', 'secretaria.vobo')->name('secretaria.vobo');
    });

    // ===== Usuario general: SOLO Mi Inventario =====
    Route::middleware(['role:Usuario'])->group(function () {
        Route::view('/mi-inventario', 'usuarios.mi_inventario')->name('usuarios.dashboard');
    });
});
