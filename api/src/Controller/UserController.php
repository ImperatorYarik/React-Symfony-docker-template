<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    )
    {}

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/user', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($requestData['email']);
        $user->setPassword($this->passwordHasher
             ->hashPassword($user, $requestData['password']));
        $user->setRoles([User::ROLE_USER]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[IsGranted(User::ROLE_USER)]
    #[Route('/user', name: 'get_all_users', methods: ['GET'])]
    public function getUsers(Request $request): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $serializedUsers = $this->serializer->serialize($users, 'json', ['groups' => ['get:collection']]);
        return new Response($serializedUsers, Response::HTTP_OK);
    }
}
