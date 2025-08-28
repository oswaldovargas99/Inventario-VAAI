<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Models\User;
use App\Http\Controllers\Admin\EquipoController;
use App\Http\Controllers\Admin\InventarioGeneralController; // Asegúrate de que este use esté bien

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta de inicio: redirige a '/inicio' si está autenticado, de lo contrario muestra la vista 'welcome'
Route::get('/', fn () => Auth::check() ? redirect()->route('inicio') : view('welcome'))->name('home');

// Grupo de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {

    // ===== Inicio inteligente =====
    // Redirige al dashboard apropiado según el rol/permisos del usuario
    Route::get('/inicio', function () {
        /** @var User $u */
        $u = Auth::user();

        if ($u->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Aprobador o VoBo: Dashboard general (no admin)
        if ($u->can('aprobar movimientos') || $u->can('vobo movimientos')) {
            return redirect()->route('panel'); // Dashboard general para aprobadores/VoBo
        }

        // Usuario general: Mi Inventario
        return redirect()->route('usuarios.dashboard');
    })->name('inicio');

    // ===== Alias opcional por compatibilidad (si algo antiguo llama /dashboard) =====
    // Redirige al dashboard de admin si el usuario tiene rol Admin
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
        ->middleware(['role:Admin'])
        ->name('dashboard');

    // ===== Rutas de Administración (solo para usuarios con rol Admin) =====
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'dashboard')->name('dashboard'); // Vista de dashboard para Admin

        Route::resource('users', UserController::class)->except(['show']); // Gestión de usuarios
        Route::resource('dependencias', DependenciaController::class)->except(['show']); // Gestión de dependencias
    });

    // ===== Gestión de Equipos (para Admin, Aprobador, Secretario) =====
    // Aquí el prefijo 'admin' se usa para la URL, pero el nombre de la ruta es 'admin.equipos.*'
    // Se ha corregido el `EquipoController@index` para que retorne `admin.equipos.index`
    Route::prefix('admin')->name('admin.')->middleware(['role:Admin|Aprobador|Secretario'])->group(function () {
        Route::resource('equipos', EquipoController::class)->except(['show']);
    });


    // ===== Dashboard GENERAL (para Aprobador o VoBo, NO usuarios generales sin esos permisos) =====
    Route::middleware(['permission:aprobar movimientos|vobo movimientos'])->group(function () {
        Route::view('/panel', 'dashboard')->name('panel'); // Usa la misma vista 'dashboard'
    });

    // ===== Inventario General (para Admin, Aprobador o VoBo) =====
    // Esta es la ÚNICA definición para 'inventario.general' y apunta al controlador correcto
    // que se encarga de pasar los datos a la vista.
    // IMPORTANTE: Este middleware requiere que el usuario tenga el rol 'Admin'
    // o los permisos 'aprobar movimientos' o 'vobo movimientos' para acceder.
    // Si solo quieres que cualquier usuario autenticado acceda, cambia el middleware a `['auth']`.
    Route::middleware(['permission:aprobar movimientos|vobo movimientos|role:Admin'])->group(function () {
        Route::get('/inventario-general', [InventarioGeneralController::class, 'index'])
            ->name('inventario.general');
    });


    // ===== Rutas para el Aprobador =====
    Route::middleware(['permission:aprobar movimientos'])->group(function () {
        Route::view('/patrimonio/aprobaciones', 'patrimonio.aprobaciones')->name('patrimonio.aprobaciones');
    });

    // ===== Rutas para VoBo (Visto Bueno) =====
    Route::middleware(['permission:vobo movimientos'])->group(function () {
        Route::view('/secretaria/vobo', 'secretaria.vobo')->name('secretaria.vobo');
    });

    // ===== Rutas para Usuario General (solo "Mi Inventario") =====
    Route::middleware(['role:Usuario'])->group(function () {
        Route::view('/mi-inventario', 'usuarios.mi_inventario')->name('usuarios.dashboard');
    });
});