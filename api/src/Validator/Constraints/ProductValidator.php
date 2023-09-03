<?php

namespace App\Validator\Constraints;
use App\Entity\Product as ProductEntity;
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

        if (!$value instanceof ProductEntity) {
            throw new UnexpectedTypeException($value, ProductEntity::class);
        }

        if($value->getCount()<=0){
            $this->context->addViolation("count <=0");
        }
        if($value->getPrice()<=0){
            $this->context->addViolation("count <=0");
        }
    }
}