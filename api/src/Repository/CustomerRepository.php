<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }
    /**
     * @param string $firstName
     * @return Customer[]|array
     */
    public function findByFirstName(string $firstName): array
    {
        return $this->createQueryBuilder('customer')
            ->andWhere('customer.first_name = :firstName')
            ->setParameter('firstName', $firstName)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $lastName
     * @return Customer[]|array
     */
    public function findByLastName(string $lastName): array
    {
        return $this->createQueryBuilder('customer')
            ->andWhere('customer.last_name = :lastName')
            ->setParameter('lastName', $lastName)
            ->getQuery()
            ->getResult();
    }

}
