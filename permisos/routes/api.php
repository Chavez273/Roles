<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

// --- RUTAS PÚBLICAS ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- RUTAS PROTEGIDAS ---
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth & Perfil
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Usuarios
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:ver_usuarios');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:crear_usuario');
    Route::get('/users/{id}', [UserController::class, 'show'])->middleware('permission:editar_usuario');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('permission:editar_usuario');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('permission:eliminar_usuario');
    // Roles
    Route::group(['middleware' => ['permission:ver_seguridad']], function () {
        Route::get('/roles', [RoleController::class, 'index']);      // 1. Listar
        Route::get('/roles/create', [RoleController::class, 'create']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);  // 3. Ver/Editar (ID numérico)
        Route::post('/roles', [RoleController::class, 'store']);     // 4. Guardar nuevo
        Route::put('/roles/{id}', [RoleController::class, 'update']); // 5. Actualizar
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // 6. Eliminar

    });

});
