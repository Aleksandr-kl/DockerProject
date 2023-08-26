<?php

namespace App\Validator\Constrains;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ProductConstraint extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return get_class($this) . "Validator";
    }

    /**
     * @return array|string|string[]
     */
    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}