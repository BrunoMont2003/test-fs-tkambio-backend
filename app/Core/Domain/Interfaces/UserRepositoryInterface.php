<?php

namespace App\Core\Domain\Interfaces;

use App\Core\Domain\User;

interface UserRepositoryInterface
{
    /**
     * Obtiene todos los usuarios.
     *
     * @return User[]
     */
    public function getAll(): array;

    /**
     * Obtiene un usuario por su correo electrónico.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
