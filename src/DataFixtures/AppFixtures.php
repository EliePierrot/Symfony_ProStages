<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

      // Creation du generateur de texte Faker
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        // CREATION DES DONNEES ENTREPRISE
        $milieuEntreprise = array (
          "Programmation",
          "Web",
          "Base de Donnee",
          "UML",
          "Python"
        );

        $tableauEntreprise = array();
        for ($i=0; $i < 5 ; $i++) {
          $entreprise = new Entreprise();
          $entreprise->setIdEntreprise($i);
          $entreprise->setNom($faker->company);
          $entreprise->setAdresse($faker->address);
          $entreprise->setMilieu($faker->randomElement($milieuEntreprise));

          $manager->persist($entreprise);

          $tableauEntreprise[]=$entreprise;
        }

        // CREATION DES DONNEES FORMATION
        $nomFormation = array (
          "DUT Informatique" =>   "Bac +2",
          "License multimedia" =>   "Bac +3",
          "DU TIC" =>   "Bac +2",
          "Ecole d ingenieur" => "Bac +5",
          "Master en Web" => "Bac +5"
        );

        $i = 0;
        $tableauFormation = array();
        foreach ($nomFormation as $intituleFormation => $niveauFormation ) {
          $formation = new Formation();
          $formation->setIdFormation($i);
          $formation->setIntitule($intituleFormation);
          $formation->setNiveau($niveauFormation);
          $formation->setVille($faker->city);

          $manager->persist($formation);


          $tableauFormation[]=$formation;

          $i = 1 + $i;
        }

        // CREATION DES DONNEE STAGES

          $stageDuree = array (
            "5 semaines",
            "1 mois",
            "2 mois",
            "8 semaines"
          );

          $stageIntitule = array (
            "Offre de stage",
            "Proposition de stage",
            "Stage au sein de notre entreprise",
            "Stage remunere"
          );

          $stageCompetencesRequises = array (
            "Pas de competences",
            "Base de donnee",
            "Java",
            "Php",
            "C++",
            "UML"
          );

          for ($i=0; $i < 15 ; $i++) {
          $stage = new Stage();
          $stage->setIdStage($i);
          $stage->setIntitule($faker->randomElement($stageIntitule));
          $stage->setDescription($faker->realText($maxNbChars = 20, $indexSize = 2));
          $stage->setDateDebut($faker->date);
          $stage->setDuree($faker->randomElement($stageDuree));
          $stage->setCompetencesRequises($faker->randomElement($stageCompetencesRequises));
          $stage->setExperienceRequise($faker->realText($maxNbChars = 20, $indexSize = 2));

          // Relation stage formation
          $numFormation = $faker->numberBetween($min = 0, $max = 4);
          $stage -> setFormations($tableauFormation[$numFormation]);
          $tableauFormation[$numFormation] -> addStage($stage);

          // Persister les objets modifiés
          $manager->persist($stage);
          $manager->persist($tableauFormation[$numFormation]);

          // Relation stage entreprise
          $numEntreprise = $faker->numberBetween($min = 0, $max = 4);
          $stage -> setEntreprises($tableauEntreprise[$numEntreprise]);
          $tableauEntreprise[$numEntreprise] -> addStage($stage);

          // Persister les objets modifiés
          $manager->persist($stage);
          $manager->persist($tableauEntreprise[$numEntreprise]);

          }

        // DONNEE EN DUR
        // $entrepriseMerkaTic = new Entreprise();
        // $entrepriseMerkaTic->setIdEntreprise(001);
        // $entrepriseMerkaTic->setNom("Merka Tic");
        // $entrepriseMerkaTic->setAdresse("merkatic@contact.fr");
        // $entrepriseMerkaTic->setMilieu("Programmation");
        // $manager->persist($entrepriseMerkaTic);

        $manager->flush();
    }
}
