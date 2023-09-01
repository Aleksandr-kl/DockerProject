<?php

namespace App\EntityListener;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductEntityListener
{

    public function prePersist(Product $product, LifecycleEventArgs $eventArgs)
    {
        $test = 1;
    }

    public function postPersist(Product $product, PostPersistEventArgs $eventArgs)
    {
        $test = $eventArgs->getObjectManager()->getUnitOfWork()->getEntityChangeSet($product);
    }

    public function preUpdate(Product $product, LifecycleEventArgs $eventArgs)
    {
        $test = 1;
    }

    public function postUpdate(Product $product, LifecycleEventArgs $eventArgs)
    {
        $test = 1;
    }

}