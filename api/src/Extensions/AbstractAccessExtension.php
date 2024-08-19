<?php

namespace App\Extensions;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractAccessExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public const FIRST_ELEMENT_ARRAY = 0;
    public const GET                 = "get";
    public const POST                = "post";
    public const PUT                 = "put";
    public const PATCH               = "patch";
    public const DELETE              = "delete";


    /**
     * @return array
     */
    public abstract function getAffectedRoles(): array;

    /**
     * @return array
     */
    public abstract function getAffectedMethods(): array;

    /**
     * AbstractCurrentUserExtension constructor.
     */
    public function __construct(protected TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     */
    public function applyToCollection(
        QueryBuilder                $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string                      $resourceClass,
        string                      $operationName = null
    ): void
    {
        if ($this->isFiltering($operationName, $resourceClass)) {
            return;
        }

        $this->buildQuery($queryBuilder);
    }

    /**
     * @param $operationName
     * @param $resourceClass
     * @return bool
     */
    protected function isFiltering($operationName, $resourceClass): bool
    {
        $token = $this->tokenStorage->getToken();

        if (is_null($token)) {
            return true;
        }

        return !$this->apply($operationName) ||
            !count(array_intersect($this->getAffectedRoles(), $token->getRoleNames())) || //if has selected role
            $resourceClass !== $this->getResourceClass();
    }

    /**
     * @param $operationName
     * @return bool
     */
    protected function apply($operationName): bool
    {
        return in_array($operationName, $this->getAffectedMethods());
    }

    /**
     * @return string
     */
    abstract public function getResourceClass(): string;

    /**
     * @param QueryBuilder $queryBuilder
     */
    abstract public function buildQuery(QueryBuilder $queryBuilder);

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param array $identifiers
     * @param string|null $operationName
     * @param array $context
     */
    public function applyToItem(
        QueryBuilder                $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string                      $resourceClass,
        array                       $identifiers,
        string                      $operationName = null,
        array                       $context = []
    ): void
    {
        if ($this->isFiltering($operationName, $resourceClass)) {
            return;
        }

        $this->buildQuery($queryBuilder);
    }

}