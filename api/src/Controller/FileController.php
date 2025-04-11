<?php

namespace App\Controller;

use App\Service\FileUploader;
use Aws\S3\S3Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FileController extends AbstractController
{
    const BUCKET_NAME = 'ztusymfonycourse';
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly EntityManagerInterface $entityManager
    )
    {}

    #[IsGranted("ROLE_USER")]
    #[Route('/upload', name: 'upload', methods: ['POST'])]
    public function uploadUserAvatar(Request $request): JsonResponse
    {
        $file = $request->files->get('image');
        $response = $this->fileUploader->uploadFile($file, $this::BUCKET_NAME);

        $user = $this->getUser();
        $user->setAvatar($response['FileName']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
