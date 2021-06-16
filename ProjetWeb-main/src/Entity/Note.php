<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
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
    private $anneScolaire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $noteDS;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $noteTp;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $noteExamen;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dsValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tpValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ExamenValid;

    /**
     * @ORM\ManyToOne(targetEntity=MatiereNiveauFiliere::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnneScolaire(): ?int
    {
        return $this->anneScolaire;
    }

    public function setAnneScolaire(int $anneScolaire): self
    {
        $this->anneScolaire = $anneScolaire;

        return $this;
    }

    public function getNoteDS(): ?float
    {
        return $this->noteDS;
    }

    public function setNoteDS(float $noteDS): self
    {
        $this->noteDS = $noteDS;

        return $this;
    }

    public function getNoteTp(): ?float
    {
        return $this->noteTp;
    }

    public function setNoteTp(float $noteTp): self
    {
        $this->noteTp = $noteTp;

        return $this;
    }

    public function getNoteExamen(): ?float
    {
        return $this->noteExamen;
    }

    public function setNoteExamen(float $noteExamen): self
    {
        $this->noteExamen = $noteExamen;

        return $this;
    }

    public function getDsValid(): ?bool
    {
        return $this->dsValid;
    }

    public function setDsValid(bool $dsValid): self
    {
        $this->dsValid = $dsValid;

        return $this;
    }

    public function getTpValid(): ?bool
    {
        return $this->tpValid;
    }

    public function setTpValid(bool $tpValid): self
    {
        $this->tpValid = $tpValid;

        return $this;
    }

    public function getExamenValid(): ?bool
    {
        return $this->ExamenValid;
    }

    public function setExamenValid(bool $ExamenValid): self
    {
        $this->ExamenValid = $ExamenValid;

        return $this;
    }

    public function getMatiere(): ?MatiereNiveauFiliere
    {
        return $this->matiere;
    }

    public function setMatiere(?MatiereNiveauFiliere $matiere): self
    {
        $this->matiere = $matiere;

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
