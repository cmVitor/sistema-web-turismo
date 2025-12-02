<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        // Guarda a senha original
        $plainPassword = $data['password'];

        // Criptografa para salvar no banco
        $data['password'] = Hash::make($plainPassword);

        // Cria o usuário
        $user = $this->userRepository->create($data);

        // Autentica e gera o token
        $token = Auth::attempt([
            'email' => $data['email'],
            'password' => $plainPassword
        ]);

        if (!$token) {
            throw ValidationException::withMessages([
                'auth' => ['Falha ao gerar token.']
            ]);
        }

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $credentials)
    {
        if (! $token = Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
        return ['message' => 'Logout realizado com sucesso'];
    }

    public function refresh()
    {
        $newToken = Auth::refresh();

        // Retorna somente o token
        return [
            'access_token' => $newToken,
        ];
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
