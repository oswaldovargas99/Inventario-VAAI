<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventarios\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ¡AÑADE ESTE IMPORT!

class DashboardController extends Controller
{
    public function adminIndex(Request $request)
    {
        $totalEquipos        = Equipo::count();
        $equiposAsignados    = Equipo::where('estado', 'Asignado')->count();
        $equiposEnAlmacen    = Equipo::where('estado', 'En Almacén')->count();
        $equiposEnMantenimiento = Equipo::where('estado', 'En Mantenimiento')->count();

        // Puedes pasar los datos compactados a la vista
        return view('dashboard', compact(
            'totalEquipos',
            'equiposAsignados',
            'equiposEnAlmacen',
            'equiposEnMantenimiento'
        ));
    }

    public function panelIndex(Request $request)
    {
        // Podrías tener lógica diferente o la misma si los KPIs son universales
        return $this->adminIndex($request); // Ejemplo simple, reutilizando lógica
    }

    // ===== AÑADE ESTE NUEVO MÉTODO COMPLETO =====
    /**
     * Muestra el inventario asignado al usuario general autenticado.
     */
    public function miInventario()
    {
        // Obtenemos el ID del usuario que ha iniciado sesión.
        $userId = Auth::id();

        // Buscamos en la tabla 'equipos' todos los que tengan asignado a este usuario.
        $equipos = Equipo::with('tipo') // Cargamos la categoría para mostrar su nombre
                         ->where('usuario_asignado_id', $userId)
                         ->get();

        // Devolvemos la vista y le pasamos la lista de equipos encontrados.
        return view('usuarios.mi_inventario', [
            'equipos' => $equipos,
        ]);
    }
}