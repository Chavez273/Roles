<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $token = session('api_token');
        // Pedimos datos frescos a la API
        $response = Http::withToken($token)->get(config('app.url') . '/api/user');

        if ($response->failed()) {
            session()->flush();
            return redirect()->route('login');
        }

        return view('dashboard', ['user' => $response->json()]);
    }
}
