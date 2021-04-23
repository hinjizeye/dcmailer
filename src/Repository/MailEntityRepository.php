<?php

namespace App\Repository;

use App\Entity\MailEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MailEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailEntity[]    findAll()
 * @method MailEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailEntity::class);
    }

    // /**
    //  * @return MailEntity[] Returns an array of MailEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MailEntity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
