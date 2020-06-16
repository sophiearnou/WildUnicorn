<?php

namespace App\Repository;

use App\Entity\GenericController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GenericController|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenericController|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenericController[]    findAll()
 * @method GenericController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenericControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenericController::class);
    }

    // /**
    //  * @return GenericController[] Returns an array of GenericController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GenericController
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
