<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear Permisos (Basado en tus secciones)
        // Permisos Generales
        Permission::create(['name' => 'ver_inicio']);

        // Permisos de Operador
        Permission::create(['name' => 'ver_viajes']);
        Permission::create(['name' => 'control_viajes']);
        Permission::create(['name' => 'ver_finanzas']); // Egresos e ingresos
        Permission::create(['name' => 'ver_actividades']);
        Permission::create(['name' => 'crear_tarea']);
        Permission::create(['name' => 'programar_viaje']);

        // Permisos de Cliente
        Permission::create(['name' => 'seguir_viaje']);
        Permission::create(['name' => 'solicitar_servicios']);
        Permission::create(['name' => 'solicitar_viaje']);

        // Permisos Administrativos
        Permission::create(['name' => 'control_usuarios']);
        Permission::create(['name' => 'ver_seguridad']);

        // 3. Crear Roles y Asignar Permisos

        // ROL: OPERADOR
        $roleOperador = Role::create(['name' => 'Operador']);
        $roleOperador->givePermissionTo([
            'ver_inicio',
            'ver_viajes',
            'control_viajes',
            'ver_finanzas',
            'ver_actividades',
            'crear_tarea',
            'programar_viaje'
        ]);

        // ROL: CLIENTE
        $roleCliente = Role::create(['name' => 'Cliente']);
        $roleCliente->givePermissionTo([
            'ver_inicio',
            'seguir_viaje',
            'solicitar_servicios',
            'solicitar_viaje'
        ]);

        // ROL: ADMINISTRADOR
        // No le asignamos permisos específicos aquí, usaremos un "Super Gate" para que tenga acceso a todo.
        $roleAdmin = Role::create(['name' => 'Administrador']);
    }
}
