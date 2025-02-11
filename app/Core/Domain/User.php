<?php

namespace App\Core\Domain;

class User
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $password,
        public ?string $birthDate,
        public string $createdAt
    ) {}

    /**
     * Crea una instancia de User desde un array de datos.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            birthDate: $data['birthDate'] ?? null,
            createdAt: $data['createdAt']
        );
    }

    /**
     * Convierte la instancia de User a un array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'birthDate' => $this->birthDate,
            'createdAt' => $this->createdAt,
        ];
    }
}
