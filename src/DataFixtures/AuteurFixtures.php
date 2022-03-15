<?php

namespace App\DataFixtures;

use App\Entity\Auteur;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++){
            $auteur = new Auteur();
            
            $auteur->setName("Name $i")
                    ->setInformations("<p>information sur l'auteur n°$i</p>");
                   
            $manager->persist($auteur);
        }

        $manager->flush();
    }
}
