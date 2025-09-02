<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Models\User;
use App\Http\Controllers\Admin\EquipoController;
use App\Http\Controllers\Admin\InventarioGeneralController; // Este controlador ahora solo redirige
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovimientoController;

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

    // ===== Rutas de ADMINISTRACIÓN GENERAL (para Admin, Aprobador, Secretario) =====
    // Este es el grupo principal que consolidará todas las rutas de 'admin'.
    Route::prefix('admin')->name('admin.')->middleware(['role:Admin|Aprobador|Secretario'])->group(function () {

        // Rutas específicas para el rol 'Admin'
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard')
            ->middleware(['role:Admin']);
        Route::resource('users', UserController::class)->except(['show'])
            ->middleware(['role:Admin']);
        Route::resource('dependencias', DependenciaController::class)->except(['show'])
            ->middleware(['role:Admin']);

        // ===== Gestión de Equipos (CONSOLIDADA) =====
        // La vista principal de equipos será ahora 'admin.equipos.index'.
        Route::resource('equipos', EquipoController::class)->except(['show']);

        // ===== Gestión de Movimientos (CONSOLIDADA) =====
        Route::resource('movimientos', MovimientoController::class)
            ->except(['show'])
            ->middleware([
                'index'   => 'permission:movimientos.view',
                'create'  => 'permission:movimientos.create',
                'store'   => 'permission:movimientos.create',
                'edit'    => 'permission:movimientos.edit',
                'update'  => 'permission:movimientos.edit',
                'destroy' => 'permission:movimientos.delete',
            ]);

        // Acciones de flujo de aprobación (específicas para Movimientos)
        Route::post('movimientos/{movimiento}/aprobar-patrimonio', [MovimientoController::class, 'aprobarPatrimonio'])
            ->middleware('permission:movimientos.approve')
            ->name('movimientos.aprobarPatrimonio');

        Route::post('movimientos/{movimiento}/aprobar-secretaria', [MovimientoController::class, 'aprobarSecretaria'])
            ->middleware('permission:movimientos.approve')
            ->name('movimientos.aprobarSecretaria');

        Route::post('movimientos/{movimiento}/rechazar', [MovimientoController::class, 'rechazar'])
            ->middleware('permission:movimientos.approve')
            ->name('movimientos.rechazar');
    });


    // ===== Dashboard GENERAL (para Aprobador o VoBo, NO usuarios generales sin esos permisos) =====
    Route::middleware(['permission:aprobar movimientos|vobo movimientos'])->group(function () {
        Route::get('/panel', [DashboardController::class, 'panelIndex'])->name('panel');
    });

    // ===== Inventario General (Ahora redirige a admin.equipos.index) =====
    // Esta ruta ya no renderiza una vista directamente, sino que redirige al listado principal de equipos.
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