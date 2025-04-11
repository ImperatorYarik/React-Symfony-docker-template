<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;

readonly class JWTAuthenticatedListener
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    /**
     * @param JWTAuthenticatedEvent $event
     * @return void
     */
    public function __invoke(JWTAuthenticatedEvent $event): void
    {
        $payload = $event->getPayload();

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $payload['username']]);
        //$user->setVisitedAt(time());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}