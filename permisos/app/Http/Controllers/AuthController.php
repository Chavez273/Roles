<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de nuevo usuario
     */
    public function register(Request $request)
    {
        // 1. Validación
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required'
        ]);

        // 2. Crear Usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Asignación de ROL Automático (Cambio solicitado)
        // Asegúrate de haber corrido el Seeder antes para que exista el rol 'Cliente'
        $user->assignRole('Administrador');

        // 4. Disparar evento de registro (Envío de correo de verificación si está configurado)
        event(new Registered($user));

        // 5. Autologin inmediato y generación de token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Obtener roles y permisos para el frontend
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ], 201);
    }

    /**
     * Inicio de Sesión
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string', // El campo se llama email pero acepta usuario
            'password' => 'required|string',
        ]);

        // Determinar si es Email o Username
        $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Intentar autenticar
        if (!Auth::attempt([$loginType => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = Auth::user();

        // Generar Token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Obtenemos los roles y permisos para enviarlos al JS
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'message' => 'Bienvenido',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'roles' => $roles,            // <--- JS usará esto
            'permissions' => $permissions // <--- JS usará esto para ocultar botones
        ]);
    }

    /**
     * Cerrar Sesión
     */
    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    /**
     * Obtener datos del usuario autenticado (Opcional, útil para refrescar datos)
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }
}
