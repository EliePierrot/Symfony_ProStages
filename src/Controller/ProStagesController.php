<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;

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
     * @Route("/admin/ajouterEntreprise", name="pro_stages_ajout_Entreprise")
     */
    public function ajouterEntreprise(Request $request, EntityManagerInterface $manager)
    {
      //Création d'une ressource vierge qui sera remplie par le formulaire
      $entreprise = new Entreprise();

      // Création du formulaire permettant de saisir une ressource
      $formulaireRessource = $this->createForm(EntrepriseType::class, $entreprise);

      /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables titre, descriptif, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $ressource*/
        $formulaireRessource->handleRequest($request);

         if ($formulaireRessource->isSubmitted() && $formulaireRessource->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stages_accueil');
         }


        return $this->render('pro_stages/ajouterEntreprise.html.twig', ['vueFormulaire' => $formulaireRessource->createView(), 'action'=>"ajout"]);
    }

    /**
     * @Route("/admin/modifierEntreprise/{id}", name="pro_stages_modif_Entreprise")
     */
    public function modifierEntreprise(Request $request, EntityManagerInterface $manager, Entreprise $entreprise)
    {

      // Création du formulaire permettant de saisir une ressource
      $formulaireRessource = $this->createForm(EntrepriseType::class, $entreprise);

      /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables titre, descriptif, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $ressource*/
        $formulaireRessource->handleRequest($request);

         if ($formulaireRessource->isSubmitted() && $formulaireRessource->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stages_accueil');
         }


        return $this->render('pro_stages/ajouterEntreprise.html.twig', ['vueFormulaire' => $formulaireRessource->createView() , 'action'=>"modifier"]);
    }


    /**
     * @Route("/admin/profile/ajouterStage", name="pro_stages_ajout_Stage")
     */
    public function ajouterStage(Request $request, EntityManagerInterface $manager)
    {
      //Création d'une ressource vierge qui sera remplie par le formulaire
      $stage = new Stage();

      // Création du formulaire permettant de saisir une ressource
      $formulaireRessource = $this->createForm(StageType::class, $stage);

      /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables titre, descriptif, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $ressource*/
        $formulaireRessource->handleRequest($request);

         if ($formulaireRessource->isSubmitted() && $formulaireRessource->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($stage);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stages_accueil');
         }


        return $this->render('pro_stages/ajouterStage.html.twig', ['vueFormulaire' => $formulaireRessource->createView(), 'action'=>"ajout"]);
    }
}
