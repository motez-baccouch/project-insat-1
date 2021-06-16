<?php

namespace App\Repository;

use App\Entity\MatiereNiveauFiliere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatiereNiveauFiliere|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatiereNiveauFiliere|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatiereNiveauFiliere[]    findAll()
 * @method MatiereNiveauFiliere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatiereNiveauFiliereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatiereNiveauFiliere::class);
    }

    public function findMatieres($semestre, $filiere, $niveau): array{
        return $this->findBy(['semestre'=>$semestre, 'filiere'=>$filiere->getId(), 'niveau'=>$niveau->getId()]);
    }


    // /**
    //  * @return MatiereNiveauFiliere[] Returns an array of MatiereNiveauFiliere objects
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
    public function findOneBySomeField($value): ?MatiereNiveauFiliere
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
