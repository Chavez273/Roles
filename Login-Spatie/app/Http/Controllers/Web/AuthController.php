<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        // URL dinámica para que funcione en local y producción
        $this->apiUrl = config('app.url') . '/api';
    }

    public function showLoginForm() { return view('auth.login'); }
    public function showRegisterForm() { return view('auth.register'); }

    public function login(Request $request)
    {
        // Petición interna a la API
        $response = Http::post($this->apiUrl . '/login', $request->all());

        if ($response->successful()) {
            $data = $response->json();
            // Guardar token en sesión
            session(['api_token' => $data['token'], 'user' => $data['user']]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Datos incorrectos.']);
    }

    public function register(Request $request)
    {
        $response = Http::post($this->apiUrl . '/register', $request->all());

        if ($response->successful()) {
            $data = $response->json();
            session(['api_token' => $data['token'], 'user' => $data['user']]);
            return redirect()->route('dashboard')->with('success', 'Cuenta creada.');
        }

        return back()->withErrors($response->json()['errors'] ?? ['error' => 'Error al registrar']);
    }

    public function logout()
    {
        $token = session('api_token');
        if($token) Http::withToken($token)->post($this->apiUrl . '/logout');

        session()->flush();
        return redirect()->route('login');
    }
}
