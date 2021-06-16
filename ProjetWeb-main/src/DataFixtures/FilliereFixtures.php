<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use App\Entity\Matiere;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class FilliereFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {



              for($i=1;$i<6;$i++){
            $niveau=new Niveau();
            $niveau->setOrdre($i);
            $niveau->setNiveau($i);
            $manager->persist($niveau);
            }


        $tfiliere = [1 => "MPI", 2 => "CBA", 3 => "GL", 4 => "RT", 5 => "IA", 6 => "IMI", 7 => "CH", 8 => "BIO"];

        foreach ($tfiliere as $key => $value){
            $filiere = new Filiere();

            $filiere->setFiliere($value);
            $filiere->setOrdre($key);

        $manager->persist($filiere);
        }


        $matiere=new Matiere();
        $matiere->setNom("Web");
        $manager->persist($matiere);
        $matiere=new Matiere();
        $matiere->setNom("Algebre");
        $manager->persist($matiere);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['groupeFiliere'];
    }
}
