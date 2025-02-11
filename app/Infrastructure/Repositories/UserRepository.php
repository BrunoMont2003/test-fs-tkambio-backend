<?php

namespace App\Infrastructure\Repositories;

use App\Core\Domain\User;
use App\Core\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Obtiene todos los usuarios.
     *
     * @return User[]
     */
    public function getAll(): array
    {
        $users = DB::table('users')->get();

        return $users->map(function ($user) {
            return User::fromArray((array) $user);
        })->toArray();
    }

    public function findByEmail(string $email): ?User
    {
        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return User::fromArray((array) $user);
    }
}
