<?php


namespace App\Entity;


use App\Service\AppDataManager;

class HistorySelection
{

    private $annee;
    private $tmpEtudiant;

    public function __construct ($etudiant, $annee, AppDataManager $appDataManager){
        $this->tmpEtudiant = $etudiant;
        if ($annee > 0) {
            $this->annee = $annee;
        } else {
            $this->annee = $appDataManager->getParametres()->getAnneScolaireCourante();
        }

    }

    /**
     * @return mixed
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param mixed $annee
     */
    public function setAnnee($annee): void
    {
        $this->annee = $annee;
    }

    /**
     * @return mixed
     */
    public function getTmpEtudiant()
    {
        return $this->tmpEtudiant;
    }

    /**
     * @param mixed $tmpEtudiant
     */
    public function setTmpEtudiant($tmpEtudiant): void
    {
        $this->tmpEtudiant = $tmpEtudiant;
    }
}