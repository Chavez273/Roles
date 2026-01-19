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
