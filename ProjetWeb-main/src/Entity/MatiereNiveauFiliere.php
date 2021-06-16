<?php

namespace App\Entity;

use App\Repository\MatiereNiveauFiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereNiveauFiliereRepository::class)
 */
class MatiereNiveauFiliere
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
    private $semestre;

    /**
     * @ORM\Column(type="float")
     */
    private $coefficient;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ds;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $examen;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="matiereNiveauFilieres", fetch ="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="matiereNiveauFilieres", fetch ="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="matiereNiveauFilieres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="matiere", orphanRemoval=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=FicheNotes::class, mappedBy="matiere")
     */
    private $ficheNotes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->ficheNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(float $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getDs(): ?bool
    {
        return $this->ds;
    }

    public function setDs(bool $ds): self
    {
        $this->ds = $ds;

        return $this;
    }

    public function getTp(): ?bool
    {
        return $this->tp;
    }

    public function setTp(bool $tp): self
    {
        $this->tp = $tp;

        return $this;
    }

    public function getExamen(): ?bool
    {
        return $this->examen;
    }

    public function setExamen(bool $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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
            $note->setMatiere($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getMatiere() === $this) {
                $note->setMatiere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FicheNotes[]
     */
    public function getFicheNotes(): Collection
    {
        return $this->ficheNotes;
    }

    public function addFicheNote(FicheNotes $ficheNote): self
    {
        if (!$this->ficheNotes->contains($ficheNote)) {
            $this->ficheNotes[] = $ficheNote;
            $ficheNote->setMatiere($this);
        }

        return $this;
    }

    public function removeFicheNote(FicheNotes $ficheNote): self
    {
        if ($this->ficheNotes->removeElement($ficheNote)) {
            // set the owning side to null (unless already changed)
            if ($ficheNote->getMatiere() === $this) {
                $ficheNote->setMatiere(null);
            }
        }

        return $this;
    }
}
