<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

//RUTAS PÚBLICAS
Route::get('/', function () {return view('login');})->name('login');
Route::get('/register', function () {return view('register');})->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register-action', [AuthController::class, 'register']);
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {return view('welcome');})->name('dashboard');
    Route::get('/permissions-control', function () {return view('permissions');})
        ->name('permissions.control')
        ->middleware('can:ver_seguridad');
    Route::get('/users-control', function () {return view('users');})
        ->name('users.control')
        ->middleware('can:ver_usuarios');
    Route::get('/finanzas', function () {return view('finanzas');})->name('finanzas.index');
    Route::get('/actividades', function () {return view('actividades');})->name('actividades.index');
    Route::get('/servicios', function () {return view('servicios');})->name('servicios.index');
    Route::get('/programar-viaje', function () {return view('programar_viaje');})->name('viajes.programar');
});
//RUTAS API INTERNAS
Route::middleware(['auth'])->group(function () {
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::put('/api/users/{id}', [UserController::class, 'update']);
    Route::delete('/api/users/{id}', [UserController::class, 'destroy']);
    Route::get('/api/roles', [RoleController::class, 'index']);
    Route::get('/api/roles/create', [RoleController::class, 'create']);
    Route::post('/api/roles', [RoleController::class, 'store']);
    Route::get('/api/roles/{id}', [RoleController::class, 'show']);
    Route::put('/api/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/api/roles/{id}', [RoleController::class, 'destroy']);
    Route::get('/api/user', [AuthController::class, 'user']);
});


