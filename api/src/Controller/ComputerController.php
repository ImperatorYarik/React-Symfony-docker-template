<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Entity\User;
use App\Service\ComputerService;
use App\Service\ComputerServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class ComputerController extends AbstractController
{

    /**
     * @param ComputerServiceInterface $computerService
     */
    public function __construct(
        private readonly ComputerServiceInterface $computerService
    )
    {}

    /**
     * @param Computer $computer
     * @return Response
     */
    #[IsGranted("ROLE_USER")]
    #[Route(path: '/computer/{id}', name: 'show_computer', methods: ['GET'])]
    public function showComputer(Computer $computer): Response
    {
        $result = $this->computerService->playOnComputer($computer);
        return new Response($result);
    }

}
