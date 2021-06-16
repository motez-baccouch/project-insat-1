<?php


namespace App\Service;


use App\Entity\Link;
use App\Entity\Parametres;
use App\Entity\SocialMedia;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class AppDataManager
{

    private $parametres;
    private $links = array();
    private $socialMedias = array();
    private $manager ;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->reloadData();
    }

    public function reloadData(): self
    {
        $this->parametres = $this->manager->getRepository(Parametres::class)->findCurrentParameters();
        $this->links = $this->manager->getRepository(Link::class)->findAll();
        $this->socialMedias = $this->manager->getRepository(SocialMedia::class)->findAll();

        return $this;
    }

    public function getParametres(): Parametres
    {
        return $this->parametres;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function getSocialMedias(): array
    {
        return $this->socialMedias;
    }

}