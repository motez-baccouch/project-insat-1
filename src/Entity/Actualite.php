<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use App\Utilities\Tools;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActualiteRepository::class)
 */
class Actualite
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
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $doc;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFormattedDescription(): string
    {
        return Tools::strToHtml($this->description);
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getPhoto(): ?Document
    {
        return $this->photo;
    }

    public function setPhoto(Document $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
