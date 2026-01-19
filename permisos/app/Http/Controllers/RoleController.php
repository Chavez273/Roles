<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // 1. Listar roles para el select
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // 2. Ver permisos de un rol
    public function show($id)
    {
        // Usamos 'web' para evitar el error "role named Cliente for guard sanctum"
        $role = Role::findById($id, 'web');

        $allPermissions = Permission::all();

        // LÓGICA ESPECIAL PARA ADMINISTRADOR:
        if ($role->name === 'Administrador' && $role->permissions->count() === 0) {
            $rolePermissions = $allPermissions->pluck('name');
        } else {
            // Para los demás roles (o si el Admin ya tiene permisos guardados), mostramos lo real.
            $rolePermissions = $role->permissions->pluck('name');
        }

        return response()->json([
            'role' => $role,
            'all_permissions' => $allPermissions,
            'role_permissions' => $rolePermissions
        ]);
    }

    // 3. Guardar cambios
    public function update(Request $request, $id)
    {
        $role = Role::findById($id, 'web');

        $request->validate([
            'permissions' => 'array'
        ]);

        // Al darle "Guardar" al Administrador, sus permisos se escribirán físicamente en la BD.
        $role->syncPermissions($request->permissions);

        return response()->json(['message' => 'Permisos actualizados correctamente.']);
    }
}
