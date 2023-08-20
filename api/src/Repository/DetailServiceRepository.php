<?php

namespace App\Repository;

use App\Entity\DetailService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailService>
 *
 * @method DetailService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailService[]    findAll()
 * @method DetailService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailService::class);
    }

//    /**
//     * @return DetailService[] Returns an array of DetailService objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailService
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
