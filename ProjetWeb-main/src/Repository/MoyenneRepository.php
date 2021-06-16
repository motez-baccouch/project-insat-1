<?php

namespace App\Repository;

use App\Entity\Moyenne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Moyenne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moyenne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moyenne[]    findAll()
 * @method Moyenne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoyenneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moyenne::class);
    }

    // /**
    //  * @return Moyenne[] Returns an array of Moyenne objects
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
    public function findOneBySomeField($value): ?Moyenne
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
