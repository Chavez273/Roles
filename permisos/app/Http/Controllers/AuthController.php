<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol (Spatie debe estar instalado correctamente)
        $user->assignRole('Administrador');

        event(new Registered($user));

        // Auto-login al registrar
        Auth::login($user);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // 1. ESTO CREA LA COOKIE DE SESIÓN (Vital para @can en Blade)
        if (!Auth::attempt([$loginType => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // 2. Regenerar ID de sesión por seguridad
        $request->session()->regenerate();

        $user = Auth::user();

        // 3. (Opcional) Token para JS, aunque con cookie ya no es estrictamente necesario
        $token = $user->createToken('auth_token')->plainTextToken;

        // Recuperamos roles y permisos REALES de la BD
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'message' => 'Bienvenido',
            'access_token' => $token, // Tu JS lo guardará en localStorage
            'token_type' => 'Bearer',
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function logout(Request $request)
    {
        // Borrar tokens
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Cerrar sesión WEB
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function user(Request $request)
    {
        // Devolvemos datos frescos de la BD
        $user = $request->user();
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ]);
    }
}
