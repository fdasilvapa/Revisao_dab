<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => Geral::USUARIO_LOGADO,
            'usuario' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['status' => true, 'message' => Geral::USUARIO_DESLOGADO];
    }
}
