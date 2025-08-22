<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DependenciaRequest;
use App\Models\Inventarios\Dependencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DependenciaController extends Controller
{
    public function index(Request $request)
    {
    $q = trim((string)$request->input('q'));

    $deps = \App\Models\Inventarios\Dependencia::query()
        ->when($q !== '', fn($query) =>
            $query->where(fn($w) =>
                $w->where('nombre','like',"%{$q}%")
                  ->orWhere('siglas','like',"%{$q}%")
                  ->orWhere('telefono','like',"%{$q}%")
            )
        )
        ->orderBy('nombre')
        ->paginate(15)
        ->appends($request->all());

        return view('admin.dependencias.index', compact('deps','q'));
    }


    
    public function create()
    {
        return view('admin.dependencias.create');
    }

    public function store(DependenciaRequest $request)
    {
        $dep = Dependencia::create($request->validated());

        Log::info('Admin creó dependencia', ['admin_id'=>auth()->id(), 'dep_id'=>$dep->id]);

        return redirect()->route('admin.dependencias.index')->with('success','Dependencia creada correctamente.');
    }

    public function edit(Dependencia $dependencia)
    {
        return view('admin.dependencias.edit', compact('dependencia'));
    }

    public function update(DependenciaRequest $request, Dependencia $dependencia)
    {
        $dependencia->update($request->validated());

        Log::info('Admin actualizó dependencia', [
            'admin_id'=>auth()->id(),
            'dep_id'  =>$dependencia->id,
            'changes' => array_keys($dependencia->getChanges()),
        ]);

        return redirect()->route('admin.dependencias.index')->with('success','Dependencia actualizada correctamente.');
    }

    public function destroy(Dependencia $dependencia)
    {
        if (User::where('dependencia_id', $dependencia->id)->exists()) {
            return back()->withErrors('No se puede eliminar: hay usuarios vinculados. Reasigna primero.');
        }

        $id = $dependencia->id;
        $dependencia->delete();

        Log::warning('Admin eliminó dependencia', ['admin_id'=>auth()->id(), 'dep_id'=>$id]);

        return redirect()->route('admin.dependencias.index')->with('success','Dependencia eliminada.');
    }
}
