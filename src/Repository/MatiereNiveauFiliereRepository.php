<?php

namespace App\Repository;

use App\Entity\MatiereNiveauFiliere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
        return $this->findBy(['semestre'=>$semestre, 'filiere'=>$filiere, 'niveau'=>$niveau]);
    }

    public function getReleve($etudiant, $anneeScolaire, $semestre)
    {

        $query = $this->createQueryBuilder('m')
            ->select(['m', 'n'])
            ->leftJoin('m.notes','n', Join::WITH, 'n.anneScolaire = ?4 and n.etudiant=?5')
            ->where('m.semestre = ?1 and m.filiere = ?2 and m.niveau = ?3 ')
            ->orderBy('m.ordre')
            ->setParameter(1, $semestre)
            ->setParameter(2, $etudiant->getFiliere()->getId())
            ->setParameter(3, $etudiant->getNiveau()->getId())
            ->setParameter(4, $anneeScolaire)
            ->setParameter(5, $etudiant->getId());

        return $query->getQuery()->getResult();
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
