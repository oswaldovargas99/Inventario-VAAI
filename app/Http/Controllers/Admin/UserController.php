<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inventarios\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $q           = trim((string) $request->input('q'));
        $rol         = $request->input('rol');
        $dependencia = $request->input('dependencia');

        $query = User::query()->with('dependencia');

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('name','like',"%{$q}%")
                    ->orWhere('email','like',"%{$q}%")
                    ->orWhere('codigo','like',"%{$q}%");
            });
        }

        if ($rol) {
            // Requiere spatie/laravel-permission
            $query->role($rol);
        }

        if ($dependencia) {
            $query->where('dependencia_id', $dependencia);
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        $roles        = ['Admin','Aprobador','Secretario','Usuario'];
        $dependencias = Dependencia::orderBy('nombre')->get(['id','siglas','nombre']);

        return view('admin.users.index', compact('users','roles','dependencias','q','rol','dependencia'));
    }

    public function create()
    {
        $dependencias = Dependencia::orderBy('nombre')->get(['id','siglas','nombre']);
        $roles = ['Admin','Aprobador','Secretario','Usuario'];

        return view('admin.users.create', compact('dependencias','roles'));
    }

    public function store(UserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->only([
                'name','email','codigo','puesto','telefono','extension','dependencia_id'
            ]);
            $data['password'] = Hash::make($request->password);

            $user = User::create($data);
            $user->syncRoles([$request->role]);

            Log::info('Admin creó usuario', [
                'admin_id' => auth()->id(),
                'user_id'  => $user->id,
            ]);
        });

        return redirect()->route('admin.users.index')
            ->with('success','Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $dependencias = Dependencia::orderBy('nombre')->get(['id','siglas','nombre']);
        $roles = ['Admin','Aprobador','Secretario','Usuario'];

        return view('admin.users.edit', compact('user','dependencias','roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        // Protecciones críticas
        if (auth()->id() === $user->id && $request->role !== 'Admin') {
            return back()->withErrors(['role' => 'No puedes quitarte el rol Admin a ti mismo.'])->withInput();
        }

        $remueveAdmin = $user->hasRole('Admin') && ($request->role !== 'Admin');
        if ($remueveAdmin && User::role('Admin')->count() <= 1) {
            return back()->withErrors(['role' => 'No puedes quitar el rol Admin al único administrador del sistema.'])->withInput();
        }

        DB::transaction(function () use ($request, $user) {
            $data = $request->only(['name','email','codigo','puesto','telefono','extension','dependencia_id']);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            $nuevoRol = $request->role;
            $rolActual = $user->getRoleNames()->first();
            if ($rolActual !== $nuevoRol) {
                $user->syncRoles([$nuevoRol]);
            }

            Log::info('Admin actualizó usuario', [
                'admin_id' => auth()->id(),
                'user_id'  => $user->id,
                'changes'  => array_keys($user->getChanges()),
            ]);
        });

        return redirect()->route('admin.users.index')
            ->with('success','Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        // Policy recomendada (si la tienes): $this->authorize('delete', $user);

        if (auth()->id() === $user->id) {
            return back()->withErrors(['delete' => 'No puedes eliminar tu propio usuario.']);
        }

        // Evita borrar al único Admin
        if ($user->hasRole('Admin') && User::role('Admin')->count() <= 1) {
            return back()->withErrors(['delete' => 'No puedes eliminar al único administrador del sistema.']);
        }

        $userId = $user->id;
        $user->delete();

        Log::warning('Admin eliminó usuario', [
            'admin_id' => auth()->id(),
            'user_id'  => $userId,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success','Usuario eliminado correctamente');
    }
}
