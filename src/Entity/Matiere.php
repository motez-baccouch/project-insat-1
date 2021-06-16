<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=MatiereNiveauFiliere::class, mappedBy="matiere", orphanRemoval=true)
     */
    private $matiereNiveauFilieres;

    public function __construct()
    {
        $this->matiereNiveauFilieres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|MatiereNiveauFiliere[]
     */
    public function getMatiereNiveauFilieres(): Collection
    {
        return $this->matiereNiveauFilieres;
    }

    public function addMatiereNiveauFiliere(MatiereNiveauFiliere $matiereNiveauFiliere): self
    {
        if (!$this->matiereNiveauFilieres->contains($matiereNiveauFiliere)) {
            $this->matiereNiveauFilieres[] = $matiereNiveauFiliere;
            $matiereNiveauFiliere->setMatiere($this);
        }

        return $this;
    }

    public function removeMatiereNiveauFiliere(MatiereNiveauFiliere $matiereNiveauFiliere): self
    {
        if ($this->matiereNiveauFilieres->removeElement($matiereNiveauFiliere)) {
            // set the owning side to null (unless already changed)
            if ($matiereNiveauFiliere->getMatiere() === $this) {
                $matiereNiveauFiliere->setMatiere(null);
            }
        }

        return $this;
    }
}
