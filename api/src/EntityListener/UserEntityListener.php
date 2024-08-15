<?php

namespace App\EntityListener;

use App\Entity\User;
use App\Services\MailerService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserEntityListener
{

    /**
     * @param MailerService $mailerService
     */
    public function __construct(private MailerService $mailerService){}

    /**
     * @param User $user
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(User $user, LifecycleEventArgs $eventArgs): void
    {

        $userReceiver = [
            'userEmail' => $user->getEmail(),
            'name' => $user->getName(),
            'surName' => $user->getSurname(),
        ];

        $Info = [
            'from' => $userReceiver['name'].' '.$userReceiver['surName'],
            'text' => 'Тестова пошта для тесту',
        ];

        //Send mail to Receiver
        $this->mailerService->SendMailFunc($userReceiver, $Info);
    }
}