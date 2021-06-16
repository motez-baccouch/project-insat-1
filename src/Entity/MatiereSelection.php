<?php


namespace App\Entity;


use App\Service\AppDataManager;

class MatiereSelection
{
    private $annee;
    private $matiere;
    private $tmpEtudiant;

    public function __construct ($etudiant, $matiere, $annee){
        $this->tmpEtudiant = $etudiant;
        $this->matiere = $matiere;
        $this->annee = $annee;

    }

    public function getMatiere()
    {
        return $this->matiere;
    }

    public function setmatiere($matiere): void
    {
        $this->matiere = $matiere;
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
    public function getAnnee()
    {
        return $this->annee;
    }
}