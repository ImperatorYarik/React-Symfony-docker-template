<?php

namespace App\Validator\Costraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class User extends Constraint
{
    public function validatedBy(): string {
        return get_class($this) . 'Validator';
    }

    public function getTargets(): array {
        return [self::CLASS_CONSTRAINT];
    }
}