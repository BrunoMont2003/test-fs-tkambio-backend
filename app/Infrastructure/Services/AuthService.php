<?php

namespace App\Infrastructure\Services;

use App\Core\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private UserRepositoryInterface $userRepository;
    private TokenService $tokenService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenService $tokenService
    ) {
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
    }

    /**
     * Inicia sesión y devuelve un token de acceso.
     *
     * @param string $email
     * @param string $password
     * @return string|null
     */
    public function login(string $email, string $password): ?string
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        // Creamos el token usando el TokenService
        $token = $this->tokenService->createToken($user->id, 'api-token');

        return $token->plainTextToken;
    }

    /**
     * Cierra la sesión y elimina los tokens de acceso.
     *
     * @param string $userId
     * @return void
     */
    public function logout(string $userId): void
    {
        $this->tokenService->deleteTokens($userId);
    }

    /**
     * Verifica si el token es válido.
     *
     * @param string $userId
     * @return bool
     */
    public function checkToken(string $userId): bool
    {
        return $this->tokenService->hasValidToken($userId, 'api-token');
    }
}
