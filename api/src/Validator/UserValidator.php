<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserValidator extends ConstraintValidator
{

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof User) {
            throw  new UnexpectedTypeException($constraint, User::class);
        }

        /** @var User $value */
/*        if ($value->getEmail() !== "user33333@gmail.com") {
            throw new BadRequestException("User email !== user33333@gmail.com");
        }*/
    }
}