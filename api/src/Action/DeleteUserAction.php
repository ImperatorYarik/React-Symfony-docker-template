<?php

namespace App\Action;

use App\Entity\User;
use App\Service\FileGetter;
use Doctrine\ORM\EntityManagerInterface;

class DeleteUserAction
{

    /**
     * @param User $data
     * @return User
     */
    public function __invoke(User $data): User
    {
        $data->setIsActive(false);

        return $data;
    }

}