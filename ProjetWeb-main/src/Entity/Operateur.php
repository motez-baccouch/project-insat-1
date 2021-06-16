<?php

namespace App\Entity;

use App\Repository\OperateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperateurRepository::class)
 */
class Operateur extends User
{

}
