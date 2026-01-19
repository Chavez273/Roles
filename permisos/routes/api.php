<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

//RUTAS PÚBLICAS
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//RUTAS PROTEGIDAS
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth & Perfil
    Route::get('/user', [AuthController::class, 'user']); // Obtener datos del usuario actual
    Route::post('/logout', [AuthController::class, 'logout']); // Cerrar sesión

    //Requiere Rol 'Administrador'
    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::get('/users', [UserController::class, 'index']);           // Leer
        Route::post('/users', [UserController::class, 'store']);          // Crear
        Route::put('/users/{id}', [UserController::class, 'update']);     // Editar
        Route::delete('/users/{id}', [UserController::class, 'destroy']); // Borrar
        // Obtener permisos de un usuario específico + todos los disponibles
        Route::get('/users/{id}/permissions', [UserController::class, 'getPermissions']);
        // Guardar la nueva lista de permisos del usuario
        Route::put('/users/{id}/permissions', [UserController::class, 'syncPermissions']);
        Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index']); // Listar roles
        Route::get('/roles/{id}', [App\Http\Controllers\RoleController::class, 'show']); // Ver permisos del rol
        Route::put('/roles/{id}', [App\Http\Controllers\RoleController::class, 'update']); // Guardar cambios
    });

});
