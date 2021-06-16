<?php

namespace App\Entity;

use App\Repository\FicheNotesRepository;
use App\Utilities\Tools;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FicheNotesRepository::class)
 */
class FicheNotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $doc;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="ficheNotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity=MatiereNiveauFiliere::class, inversedBy="ficheNotes", fetch="EAGER")
     */
    private $matiere;

    private $tmpFiliereNiveau;
    private $tmpSemestre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

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

    public function getTmpFiliereNiveau()
    {
        if(!empty($this->getMatiere())) {
            $filiere = $this->getMatiere()->getFiliere();
            $niveau = $this->getMatiere()->getNiveau();
            return !empty($filiere) && !empty($niveau)
                ? Tools::toExId($filiere->getId(), $niveau->getId())
                : $this->tmpFiliereNiveau;
        }
        return $this->tmpFiliereNiveau;
    }

    /**
     * @return mixed
     */
    public function getTmpSemestre()
    {
        return !empty($this->getMatiere()) ? $this->getMatiere()->getSemestre() : $this->tmpSemestre;
    }

    /**
     * @param mixed $tmpFiliereNiveau
     */
    public function setTmpFiliereNiveau($tmpFiliereNiveau): void
    {
        $this->tmpFiliereNiveau = $tmpFiliereNiveau;
    }

    /**
     * @param mixed $tmpSemestre
     */
    public function setTmpSemestre($tmpSemestre): void
    {
        $this->tmpSemestre = $tmpSemestre;
    }


}
