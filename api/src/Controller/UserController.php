<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/user', name: 'get_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
       $users = $this->entityManager->getRepository(User::class)->findAll();

       return new JsonResponse($users, Response::HTTP_OK);
    }

    #[Route(path: '/user', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);
        $user = new User();

        $user->setEmail($userData['email']);
        $user->setMyName($userData['name']);
        $user->setPassword($userData['password']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_OK);
    }

}
