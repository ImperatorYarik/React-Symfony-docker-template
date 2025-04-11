<?php

namespace App\Validator\Costraints;

use App\Entity\User;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Query;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws UniqueConstraintViolationException
     * @throws \Exception
     */
    public function validate(mixed $value, Constraint $constraint): void
    {

    }
}