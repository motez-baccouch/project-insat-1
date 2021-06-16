<?php

namespace App\Entity;

use App\Repository\EmploiDuTempsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmploiDuTempsRepository::class)
 */
class EmploiDuTemps
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeScolaire;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $doc;



    /**
     * @ORM\Column(type="integer")
     */
    private $semestre;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="emploiDuTemps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneeScolaire(): ?int
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(int $anneeScolaire): self
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getDoc(): ?Document
    {
        return $this->doc;
    }

    public function setDoc(Document $doc): self
    {
        $this->doc = $doc;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }
}
