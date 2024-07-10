<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserControlerController extends AbstractController
{
    #[Route('/user/controler', name: 'app_user_controler')]
    public function index(): Response
    {
        return $this->render('user_controler/index.html.twig', [
            'controller_name' => 'UserControlerController',
        ]);
    }
}
