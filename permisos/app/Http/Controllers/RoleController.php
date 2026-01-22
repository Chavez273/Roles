<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // 1. Listar Roles (Tabla principal)
    public function index()
    {
        $roles = Role::all();
        //$roles = Role::withCount('users')->get();
        //$roles = Role::all();
        foreach ($roles as $role) {
        $role->users_count = DB::table('model_has_roles')
            ->where('role_id', $role->id)
            ->count();
    }

        return response()->json($roles);
    }
    public function create()
    {
        $allPermissions = Permission::all();

        return response()->json([
            'role' => null,
            'all_permissions' => $allPermissions,
            'role_permissions' => [] // Array vacío porque es nuevo
        ]);
    }

    public function show($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $allPermissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name');

        return response()->json([
            'role' => $role,
            'all_permissions' => $allPermissions,
            'role_permissions' => $rolePermissions
        ]);
    }

    // 4. Guardar Nuevo Rol
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if($request->has('permissions')){
            // syncPermissions es más seguro que givePermissionTo
            $role->syncPermissions($request->permissions);
        }

        return response()->json(['message' => 'Rol creado exitosamente']);
    }

    // 5. Actualizar Rol existente
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        // Validamos nombre solo si cambió para evitar error de "unique" con el mismo nombre
        if($role->name != $request->name){
            $request->validate(['name' => 'required|unique:roles,name']);
            $role->name = $request->name;
            $role->save();
        }

        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return response()->json(['message' => 'Rol actualizado correctamente.']);
    }

    // 6. Eliminar Rol
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        // Seguridad: No borrar al Admin
        if($role->name === 'Administrador') {
            return response()->json(['message' => 'No puedes eliminar el rol Administrador'], 403);
        }

        $role->delete();
        return response()->json(['message' => 'Rol eliminado']);
    }
}
