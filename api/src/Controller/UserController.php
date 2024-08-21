<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController
{

    public function __construct(
        protected SerializerInterface $serializer,
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $userPasswordHasher,
    )
    {}

    #[Route('/api/create-user', name: 'create_user', methods: ['POST'])]
    public function createUSer(Request $request): Response
    {
        $userData = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($userData['email']);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $userData['password']));
        $user->addRole(User::ROLE_USER);
        $user->setName($userData['name']);
        $user->setSurname($userData['surname']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new JsonResponse('User created', Response::HTTP_CREATED);
    }

}