<?php

namespace App\EntityListeners;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserEntityListener
{
    /**
     * @param User $user
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $user->setRoles([User::ROLE_USER]);
    }
}