<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definir Permisos
        $permissions = [
            // USUARIOS
            'ver_usuarios',      // Ver la lista
            'crear_usuario',     // Botón crear
            'editar_usuario',    // Botón editar
            'eliminar_usuario',  // Botón eliminar

            'ver_viajes', 'control_viajes', 'programar_viaje',
            'ver_actividades', 'ver_finanzas',
            'crear_tarea', 'solicitar_servicios', 'solicitar_viaje',
            'seguir_viaje', 'ver_seguridad'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. ROL ADMINISTRADOR (Tiene TODO)
        $roleAdmin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions(Permission::all());

        // 4. OTROS ROLES (Ejemplos básicos)
        $roleOperador = Role::firstOrCreate(['name' => 'Operador', 'guard_name' => 'web']);
        $roleOperador->syncPermissions(['ver_viajes', 'ver_actividades']); // No puede gestionar usuarios

        $roleCliente = Role::firstOrCreate(['name' => 'Cliente', 'guard_name' => 'web']);
        $roleCliente->syncPermissions(['solicitar_servicios']);
    }
}
