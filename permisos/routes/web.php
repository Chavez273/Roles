<?php

use Illuminate\Support\Facades\Route;

// Página de Inicio de Sesión
Route::get('/', function () {return view('login');})->name('login');
// Página de Registro
Route::get('/register', function () {return view('register');})->name('register');
// Panel Principal
Route::get('/dashboard', function () {return view('welcome');})->name('dashboard');
// Panel de Control de Usuarios (Solo Admin)
Route::get('/users-control', function () {return view('users');})->name('users.control');
Route::get('/permissions-control', function () {return view('permissions');})->name('permissions.control');
Route::get('/finanzas', function () {return view('finanzas');})->name('finanzas.index');
Route::get('/actividades', function () {return view('actividades');})->name('actividades.index');
Route::get('/servicios', function () {return view('servicios');})->name('servicios.index');
Route::get('/programar-viaje', function () {return view('programar_viaje');})->name('viajes.programar');
Route::group(['middleware' => ['auth:sanctum']], function () {
    // 1. Ver lista (index) -> Requiere permiso 'ver_usuarios'
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware('permission:ver_usuarios');
    // 2. Crear usuario (store) -> Requiere permiso 'crear_usuario'
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->middleware('permission:crear_usuario');
    // 3. Editar usuario (update y show) -> Requiere permiso 'editar_usuario'
    Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->middleware('permission:editar_usuario'); // Para cargar el modal
    Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('permission:editar_usuario'); // Para guardar cambios
    // 4. Eliminar usuario (destroy) -> Requiere permiso 'eliminar_usuario'
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('permission:eliminar_usuario');
    //Route::get('/permissions-control', function () {return view('permissions');})->name('permissions.control');
});


