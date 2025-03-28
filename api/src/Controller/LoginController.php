<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}


    #[Route('/login/{name}/{id}', name: 'app_login')]
    public function index(string $name, int $id): Response
    {
        $string = $name . ' | ' . $id;
        return new Response($string, Response::HTTP_OK);
    }

    #[Route('/token/', name: 'app_token', methods: ['POST'])]
    public function getToken(Request $request): Response
    {
        $data = $request->getContent();

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/user-create', name: 'app_token', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $userData = json_decode($request->getContent(), true);

        $user = new User();
        $user
            ->setEmail($userData['email'])
            ->setPassword(
                password_hash($userData['password'],
                    PASSWORD_DEFAULT))
            ->setMyName($userData['name']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_CREATED);
    }

}
