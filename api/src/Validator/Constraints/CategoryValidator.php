<?php

namespace App\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class CategoryValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Category) {
            throw new UnexpectedTypeException($constraint, Category::class);
        }

        if (!$value instanceof \App\Entity\Category) {
            throw new UnexpectedTypeException($value, \App\Entity\Category::class);
        }

        $name = $value->getName();

        if (strlen($name) > 15){
            $this->context->addViolation('Name should not be longer than 50 characters.');
        }
    }
}