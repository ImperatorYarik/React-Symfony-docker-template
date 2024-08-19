<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
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

    #[Route('/api/read-user/{id}', name: 'app_read_user', methods: ['GET'])]
    public function getAllUsers(string $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);


        return new JsonResponse($user, Response::HTTP_OK);
    }

    #[Route('/api/create-order', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);
        $user = $this->em->getRepository(User::class)->find($requestContent['order']['user_id']);
        $requestContent['order']['user_id'] = $user;
        $order = new Order();
        $order->setUser($user);
        $order->setTotalPrice($requestContent['order']['total_price']);
        $this->em->persist($order);
        $this->em->flush();

        return new JsonResponse([], Response::HTTP_CREATED);
    }

}

