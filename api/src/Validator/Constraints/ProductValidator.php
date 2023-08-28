<?php

namespace App\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class ProductValidator extends ConstraintValidator
{

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Product) {
            throw new UnexpectedTypeException($constraint, Product::class);
        }

        if (!$value instanceof Product) {
            throw new UnexpectedTypeException($value, Product::class);
        }


        if (empty($value->getName())) {
            $this->context->buildViolation('Product name cannot be empty.')
                ->atPath('name')
                ->addViolation();
        }

        if ($value->getCount() < 0) {
            $this->context->buildViolation('Product count must be a positive value.')
                ->atPath('count')
                ->addViolation();
        }

        if ($value->getPrice() <= 0) {
            $this->context->buildViolation('Product price must be a positive value.')
                ->atPath('price')
                ->addViolation();
        }
    }
}