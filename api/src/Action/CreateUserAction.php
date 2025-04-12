<?php

namespace App\Action;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CreateUserAction
{

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface          $validator,
    )
    {}

    /**
     * @param User $data
     * @return User
     */
    public function __invoke(User $data) : User
    {
        $this->validator->validate($data);
        $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
        $data->setPassword($hashedPassword);
        $data->setRoles([User::ROLE_USER]);
        $data->setIsActive(true);

        return $data;
    }

}