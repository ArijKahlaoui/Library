<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++){
            $article = new Article();
            
            $article->setTitle("Article $i")
                    ->setAuteur("Auteur $i")
                    ->setContent("<p>le contenu de l'article n°$i</p>")
                    ->setImage("https://images.epagine.fr/063/9782075128063_1_75.jpg")
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
