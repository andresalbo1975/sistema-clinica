<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validar que nos envíen correo y contraseña
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Intentar iniciar sesión (Laravel compara las contraseñas encriptadas por ti)
        if (Auth::attempt($credenciales)) {
            // El usuario existe y la contraseña es correcta
            $user = Auth::user();
            // Creamos un "Token" (una pulsera VIP) para que Vue la use
            $token = $user->createToken('token_recepcion')->plainTextToken;

            return response()->json([
                'mensaje' => '¡Bienvenida, ' . $user->name . '!',
                'token' => $token,
                'usuario' => $user
            ]);
        }

        // 3. Si falla
        return response()->json(['error' => 'Correo o contraseña incorrectos'], 401);
    }
}