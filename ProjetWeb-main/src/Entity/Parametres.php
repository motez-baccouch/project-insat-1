<?php

namespace App\Entity;

use App\Repository\ParametresRepository;
use App\Utilities\Tools;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametresRepository::class)
 */
class Parametres
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
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneScolaireCourante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAnneScolaireCourante(): ?int
    {
        return $this->anneScolaireCourante;
    }

    public function setAnneScolaireCourante(int $anneScolaireCourante): self
    {
        $this->anneScolaireCourante = $anneScolaireCourante;

        return $this;
    }

    public function getFormattedAdresse(): string
    {
        return Tools::strToHtml($this->adresse);
    }

    public function getAnneeScolaireCouranteFormatted(): string{
        return ($this->anneScolaireCourante - 1)  ." / ". $this->anneScolaireCourante;
    }
}
