<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController
{

    public function __construct(protected EntityManagerInterface $em, protected SerializerInterface $serializer, private ValidatorInterface $validator)
    {
    }

    #[Route('/api/create-user', name: 'app_create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse((string) $errors, Response::HTTP_BAD_REQUEST);
        };

        $this->em->persist($user);
        $this->em->flush();

        $jsonData = $this->serializer->serialize($user, 'json', ['groups' => 'user:read']);

        return new JsonResponse($jsonData, Response::HTTP_CREATED, [], true);
    }
}

