<?php

namespace App\Validator\Constraints;
use App\Entity\Category as CategoryEntity;
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
            throw new UnexpectedTypeException($value, CategoryEntity::class);
        }

        $name = $value->getName();

        if (strlen($name) > 20){
            $this->context->addViolation('Name should not be longer than 20 characters.');
        }
    }
}