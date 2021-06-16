<?php

namespace App\Entity;

use App\Repository\DownloadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DownloadRepository::class)
 */
class Download
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
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $doc;

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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

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
}
