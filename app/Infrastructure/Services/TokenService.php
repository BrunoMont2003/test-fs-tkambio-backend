<?php

namespace App\Infrastructure\Services;

use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Str;

class TokenService
{
    /**
     * Crea un token de acceso para un usuario.
     *
     * @param string $userId
     * @param string $tokenName
     * @return NewAccessToken
     */
    public function createToken(string $userId, string $tokenName): NewAccessToken
    {
        $token = Str::random(40);

        $accessToken = new PersonalAccessToken();

        $accessToken->forceFill([
            'tokenable_id' => $userId,
            'tokenable_type' => 'App\Core\Domain\User',
            'name' => $tokenName,
            'token' => hash('sha256', $token),
            'abilities' => ['*'],
        ]);

        $accessToken->save();
        return new NewAccessToken($accessToken, $token);
    }

    /**
     * Elimina todos los tokens de acceso de un usuario.
     *
     * @param string $userId
     * @return void
     */
    public function deleteTokens(string $userId): void
    {
        PersonalAccessToken::where('tokenable_id', $userId)
            ->where('tokenable_type', 'App\Core\Domain\User')
            ->delete();
    }

    /**
     * Verifica si un token es válido.
     *
     * @param string $token
     * @return bool
     */
    public function isValidToken(string $token): bool
    {
        return PersonalAccessToken::where('token', hash('sha256', $token))->exists();
    }
}
