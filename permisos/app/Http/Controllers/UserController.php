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
    // 1. Listar Usuarios
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::pluck('name');
        return response()->json(['users' => $users, 'roles' => $roles]);
    }

    // 2. Guardar Nuevo Usuario (Email Automático)
    public function store(Request $request)
    {
        // Validamos solo lo necesario
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name', // Nombre único (Login)
            'role' => 'required|exists:roles,name',
            'password' => 'required|min:8'
        ]);

        // Generar Email Falso Automático (invisible para el usuario)
        // Ejemplo: juan.perez.8492@sistema.local
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

    // 3. Actualizar Usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:8'
        ]);

        $user->name = $request->name;

        // Si se envió contraseña nueva, la actualizamos
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Seguridad: Evitar que el admin se quite el rol a sí mismo
        if ($user->id === auth()->id() && $request->role !== 'Administrador') {
             return response()->json(['message' => 'No puedes quitarte el rol de Admin a ti mismo'], 403);
        }

        $user->syncRoles([$request->role]);

        return response()->json(['message' => 'Usuario actualizado correctamente']);
    }

    // 4. Eliminar Usuario
    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return response()->json(['message' => 'No puedes eliminar tu propia cuenta'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    // 5. Obtener Permisos del Usuario y del Sistema
public function getPermissions($id)
    {
        $user = User::findOrFail($id);

        // Todos los permisos posibles en la base de datos
        $allPermissions = \Spatie\Permission\Models\Permission::all();

        if ($user->hasRole('Administrador')) {
             $userPermissions = $allPermissions->pluck('name');
        } else {
             // Si no es admin, buscamos sus permisos reales
             $userPermissions = $user->getAllPermissions()->pluck('name');
        }

        return response()->json([
            'user' => $user,
            'all_permissions' => $allPermissions,
            'user_permissions' => $userPermissions
        ]);
    }

    // 6. Sincronizar Permisos (Guardar los checks)
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

