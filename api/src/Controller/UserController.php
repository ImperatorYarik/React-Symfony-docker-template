<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface    $serializer,
    )
    {}

    #[Route(path: '/user', name: 'get_users', methods: ['GET'])]
    public function getUsers(): Response
    {
       return new Response($this->serializer
           ->serialize($this->entityManager
               ->getRepository(User::class)
               ->findAll(),
               'json', ['groups' => 'user:collection:get']),
           Response::HTTP_OK);
    }

    #[Route(path: '/user/{id}', name: 'get_item_users', methods: ['GET'])]
    public function getItemUsers(int $id): Response
    {
        return new Response($this->serializer
            ->serialize($this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['id' => $id]),
                'json', ['groups' => 'user:item:get']),
            Response::HTTP_OK);
    }

    #[Route(path: '/user', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(),
            User::class,
            'json',
            ['groups' => 'user:collection:post']
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    #[Route(path: '/user/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $newData = json_decode($request->getContent(), true);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        $user->setMyName($newData['name']);
        $user->setEmail($newData['email']);
        $user->setPassword($newData['password']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_ACCEPTED);
    }

    #[Route(path: '/user/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
