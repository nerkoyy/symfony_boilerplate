<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Oignon;
use App\Entity\Pain;
use App\Entity\Sauce;
use App\Entity\Image;
use App\Entity\Commentaire;
use App\Entity\Burger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // ---- Oignons ----
        $oignons = [];
        for ($i = 0; $i < 50; $i++) {
            $oignon = new Oignon();
            $oignon->setName("Oignon " . $faker->word());
            $manager->persist($oignon);
            $oignons[] = $oignon;
        }

        $pains = [];
        for ($i = 0; $i < 50; $i++) {
            $pain = new Pain();
            $pain->setName("Pain " . $faker->word());
            $manager->persist($pain);
            $pains[] = $pain;
        }

        // ---- Sauces ----
        $sauces = [];
        for ($i = 0; $i < 50; $i++) {
            $sauce = new Sauce();
            $sauce->setName("Sauce " . $faker->word());
            $manager->persist($sauce);
            $sauces[] = $sauce;
        }

        $images = [];
        for ($i = 0; $i < 50; $i++) {
            $image = new Image();
            $image->setName($faker->imageUrl(400, 300));
            $manager->persist($image);
            $images[] = $image;
        }

        // ---- Commentaires ----
        for ($i = 0; $i < 50; $i++) {
            $commentaire = new Commentaire();
            $commentaire->setName($faker->sentence()); // ou setContenu selon ton entité
            $manager->persist($commentaire);
        }

        // ---- Burgers ----
        $burgers = [];
        for ($i = 0; $i < 50; $i++) {
            $burger = new Burger();
            $burger->setName($faker->word());
            $burger->setPrice($faker->randomFloat(2, 5, 20));

            // Assigner une image unique
            $burger->setImage($images[$i]);

            // Assigner un pain aléatoire
            $burger->setPain($pains[array_rand($pains)]);

            // Ajouter 1 à 3 sauces aléatoires
            for ($j = 0; $j < rand(1, 3); $j++) {
                $burger->addSauce($sauces[array_rand($sauces)]);
            }

            // Ajouter 1 oignon aléatoire
            $burger->addOignon($oignons[array_rand($oignons)]);

            $manager->persist($burger);
            $burgers[] = $burger; // stocker dans le tableau si besoin plus tard
        }


        $manager->flush();
    }
}
