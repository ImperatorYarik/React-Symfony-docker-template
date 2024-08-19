<?php

namespace App\Extensions\User;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class UserExtension extends AbstractUserAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET
        ];
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Order::class;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return void
     */
    public function buildQuery(QueryBuilder $queryBuilder): void
    {
        dd("Helolo");
        $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];

        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $binaryId = $currentUser->getId()->toBinary();

        $queryBuilder
            ->andWhere($rootAlias.'.user = :user')
            ->setParameter('user', $binaryId);
    }
}