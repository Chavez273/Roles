<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::pluck('name');
        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'role' => 'required|exists:roles,name',
            'password' => 'required|min:8'
        ]);

        $cleanName = Str::slug($request->name, '.');
        $autoEmail = $cleanName . '.' . rand(1000, 9999) . '@sistema.local';

        $user = User::create([
            'name' => $request->name,
            'email' => $autoEmail,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return response()->json(['message' => 'Usuario creado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:8'
        ]);

        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user->id === auth()->id() && $request->role !== 'Administrador') {
             return response()->json(['message' => 'No puedes quitarte el rol de Admin a ti mismo'], 403);
        }

        $user->syncRoles([$request->role]);

        return response()->json(['message' => 'Usuario actualizado correctamente']);
    }

    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return response()->json(['message' => 'No puedes eliminar tu propia cuenta'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

public function getPermissions($id)
    {
        $user = User::findOrFail($id);

        $allPermissions = \Spatie\Permission\Models\Permission::all();

        if ($user->hasRole('Administrador')) {
             $userPermissions = $allPermissions->pluck('name');
        } else {
             $userPermissions = $user->getAllPermissions()->pluck('name');
        }

        return response()->json([
            'user' => $user,
            'all_permissions' => $allPermissions,
            'user_permissions' => $userPermissions
        ]);
    }

    public function syncPermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'permissions' => 'array'
        ]);

        $user->syncPermissions($request->permissions);

        return response()->json(['message' => 'Permisos actualizados correctamente']);
    }

}

