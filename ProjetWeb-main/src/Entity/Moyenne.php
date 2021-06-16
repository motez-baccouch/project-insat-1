<?php

namespace App\Entity;

use App\Repository\MoyenneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoyenneRepository::class)
 */
class Moyenne
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
     * @ORM\Column(type="float")
     */
    private $sem1;

    /**
     * @ORM\Column(type="float")
     */
    private $sem2;

    /**
     * @ORM\Column(type="float")
     */
    private $annuelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sem1Valid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sem2Valid;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="moyennes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

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

    public function getSem1(): ?float
    {
        return $this->sem1;
    }

    public function setSem1(float $sem1): self
    {
        $this->sem1 = $sem1;

        return $this;
    }

    public function getSem2(): ?float
    {
        return $this->sem2;
    }

    public function setSem2(float $sem2): self
    {
        $this->sem2 = $sem2;

        return $this;
    }

    public function getAnnuelle(): ?float
    {
        return $this->annuelle;
    }

    public function setAnnuelle(float $annuelle): self
    {
        $this->annuelle = $annuelle;

        return $this;
    }

    public function getSem1Valid(): ?bool
    {
        return $this->sem1Valid;
    }

    public function setSem1Valid(bool $sem1Valid): self
    {
        $this->sem1Valid = $sem1Valid;

        return $this;
    }

    public function getSem2Valid(): ?bool
    {
        return $this->sem2Valid;
    }

    public function setSem2Valid(bool $sem2Valid): self
    {
        $this->sem2Valid = $sem2Valid;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }
}
