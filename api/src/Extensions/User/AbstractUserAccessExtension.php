<?php


namespace App\Extensions\User;

use App\Entity\User;
use App\Extensions\AbstractAccessExtension;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractUserAccessExtension extends AbstractAccessExtension
{
    /**
     * @return array
     */
    public function getAffectedRoles(): array
    {
        return [
            User::ROLE_USER
        ];
    }
}