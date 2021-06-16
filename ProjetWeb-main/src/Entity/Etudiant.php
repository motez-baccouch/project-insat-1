<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant extends User
{

    /**
     * @ORM\Column(type="integer")
     */
    private $numInscription;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Moyenne::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $moyennes;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $notes;

    public function __construct()
    {
        $this->moyennes = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }


    public function getNumInscription(): ?int
    {
        return $this->numInscription;
    }

    public function setNumInscription(int $numInscription): self
    {
        $this->numInscription = $numInscription;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Moyenne[]
     */
    public function getMoyennes(): Collection
    {
        return $this->moyennes;
    }

    public function addMoyenne(Moyenne $moyenne): self
    {
        if (!$this->moyennes->contains($moyenne)) {
            $this->moyennes[] = $moyenne;
            $moyenne->setEtudiant($this);
        }

        return $this;
    }

    public function removeMoyenne(Moyenne $moyenne): self
    {
        if ($this->moyennes->removeElement($moyenne)) {
            // set the owning side to null (unless already changed)
            if ($moyenne->getEtudiant() === $this) {
                $moyenne->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }

}
