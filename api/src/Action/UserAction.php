<?php

namespace App\Action;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAction
{
    public function __construct(protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function __invoke(User $data): User
    {
        $data->setPassword($this->passwordHasher->hashPassword($data, $data->getPassword()));

        return $data;
    }
}