<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

      // Creation du generateur de texte Faker
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        $entrepriseMerkaTic = new Entreprise();
        $entrepriseMerkaTic->setIdEntreprise(001);
        $entrepriseMerkaTic->setNom("Merka Tic");
        $entrepriseMerkaTic->setAdresse("merkatic@contact.fr");
        $entrepriseMerkaTic->setMilieu("Programmation");

        $manager->persist($entrepriseMerkaTic);
        $manager->flush();
    }
}
