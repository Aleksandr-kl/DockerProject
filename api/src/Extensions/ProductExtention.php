<?php

namespace App\Extensions;

use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;

class ProductExtention extends UserRelationExtension
{
    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Product::class;
    }

}