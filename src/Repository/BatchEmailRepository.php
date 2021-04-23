<?php

namespace App\Repository;

use App\Entity\BatchEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BatchEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method BatchEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method BatchEmail[]    findAll()
 * @method BatchEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatchEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BatchEmail::class);
    }

    // /**
    //  * @return BatchEmail[] Returns an array of BatchEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BatchEmail
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
