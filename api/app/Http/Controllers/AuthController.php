<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Dotenv\Exception\ValidationException;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    // Registrar usuário
    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            // registra e retorna o token
            $result = $this->authService->register($validated);

            return response()->json([
                'message' => 'Usuário registrado com sucesso.',
                'token' => $result['token'],
                'user' => $result['user']
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    // Login
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated(); 

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    // Retornar usuário autenticado
    public function me()
    {
        return response()->json($this->authService->getCurrentUser());
    }

    // Logout
    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json($result);
    }

    // Refresh token
    public function refresh()
    {
        $result = $this->authService->refresh();
        return response()->json($result);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
