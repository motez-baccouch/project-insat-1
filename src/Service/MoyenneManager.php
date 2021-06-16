<?php


namespace App\Service;


use App\Entity\Etudiant;
use App\Entity\Matiere;
use Doctrine\ORM\EntityManagerInterface;

class MoyenneManager{

             private $em;

             public function __construct(EntityManagerInterface $em){
                    $this->em = $em;
                 }

    public  function moyenneMatiere(Etudiant $etudiant, Matiere $matiere){
        $repository1=$this->em->getRepository('App:MatiereNiveauFiliere');
        $repository2= $this->em->getRepository('App:Note');
        $mat=$repository1->findOneBy(['matiere'=>$matiere]);
        $notes=$repository2->findOneBy(['etudiant'=>$etudiant,'matiere'=>$mat]);

        if($mat->getTp()){
            $tp=true;
        }else{
            $tp=false;
        }

        if($tp){
            $moyenne=$notes->getNoteDS()*0.25 + $notes->getNoteTp()*0.25 +$notes->getNoteExamen()*0.5;
        }
        else{
            $moyenne=$notes->getNoteDS()*0.3 +$notes->getNoteExamen()*0.7;
        }
        return $moyenne;
    }

    public  function moyenneSemester(Etudiant $etudiant , int $sem){
        $repository1= $this->em->getRepository('App:MatiereNiveauFiliere');

        $fil=$etudiant->getFiliere();
        $niv=$etudiant->getNiveau();
        $mats=$repository1->findBy(['filiere'=>$fil , 'niveau'=>$niv , 'semestre'=>$sem]);

        $score=0;
        $coef=0;
        foreach($mats as $mat){
            $score=$score + self::moyenneMatiere($etudiant,$mat->getMatiere())*$mat->getCoefficient();;

            $coef=$coef+$mat->getCoefficient();
        }

        return $score/$coef;
    }

    public  function moyenneAnnuel($etudiant){

        return (self::moyenneSemester($etudiant , 1)+ self::moyenneSemester($etudiant ,2))/2 ;
    }



}