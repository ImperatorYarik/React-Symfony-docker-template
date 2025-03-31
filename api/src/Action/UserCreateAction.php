<?php

namespace App\Action;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserCreateAction
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ){}

    public function __invoke(User $data): User
    {
        $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
        $data->setPassword($hashedPassword);
        $data->setRoles([ USER::ROLE_USER ]);

        return $data;
    }
}