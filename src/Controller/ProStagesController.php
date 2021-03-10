<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_accueil")
     */
    public function index()
    {
        // Recuperer le repository de l'entité STAGES
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Recuperer les données dans la base
        $stages = $repositoryStage->findAll();

        return $this->render('pro_stages/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/entreprises/{nom}", name="pro_stages_entreprises")
     */
    public function listeEntreprises($nom)
    {
      // Recuperer le repository de l'entité Stage
      $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Recuperer les données dans la base
      $stage = $repositoryStage->findByEntreprise($nom);

        return $this->render('pro_stages/listeEntreprises.html.twig',
        ['stage' => $stage , 'nom' => $nom]);
    }




    /**
     * @Route("/entreprises/", name="pro_stages_entreprises_sans_id")
     */
    public function listeEntreprisesSansId(): Response
    {
        return $this->render('pro_stages/listeEntreprises.html.twig',
        ['entrepriseid' => 0]);
    }


    /**
     * @Route("/filtreEntreprises", name="pro_stages_filtre_entreprises")
     */
    public function filtreEntreprises()
    {
      // Recuperer le repository de l'entité entreprise
      $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

      // Recuperer les données dans la base
      $entreprises = $repositoryEntreprise->findAll();

      return $this->render('pro_stages/filtreEntreprises.html.twig' , ['entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations/{intitule}", name="pro_stages_formations")
     */
    public function listeFormations($intitule)
    {
      // Recuperer le repository de l'entité ENTREPRISE
      $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Recuperer les données dans la base
      $stage = $repositoryStage->findByFormationDql($intitule);

      return $this->render('pro_stages/listeFormations.html.twig',
          ['stage' => $stage , 'intitule' => $intitule]);
    }

    /**
     * @Route("/filtreFormations", name="pro_stages_filtre_formations")
     */
    public function filtreFormations()
    {
      // Recuperer le repository de l'entité entreprise
      $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

      // Recuperer les données dans la base
      $formations = $repositoryFormation->findAll();

      return $this->render('pro_stages/filtreFormations.html.twig', ['formations' => $formations]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stages_stages")
     */
    public function descriptifStage($id)
    {
      // Récupérer le repository de l'entité Stages
    $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);

    // Récupérer les stages enregistrées en BD
    $stages = $repositoryStages->find($id);


        return $this->render('pro_stages/descriptifStage.html.twig',
      [ 'stages' => $stages]);
    }

    /**
     * @Route("/ajouterEntreprise", name="pro_stages_ajout_Entreprise")
     */
    public function ajouterEntreprise()
    {
      //Création d'une ressource vierge qui sera remplie par le formulaire
      $entreprise = new Entreprise();

      // Création du formulaire permettant de saisir une ressource
      $formulaireRessource = $this->createFormBuilder($entreprise)
      ->add('idEntreprise')
      ->add('nom')
      ->add('adresse')
      ->add('milieu')
      ->getForm();

        return $this->render('pro_stages/ajouterEntreprise.html.twig', ['vueFormulaire' => $formulaireRessource->createView()]);
    }
}
