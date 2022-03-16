<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Repository\ClientsRepository;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BucketController extends AbstractController
{
    /**
     * @Route("/home", name="app_bucket")
     */
    public function index(): Response
    {
        return $this->render('bucket/index.html.twig', [
            'controller_name' => 'BucketController',
        ]);
    }

    /**
     * @Route("/main", name="app_aboutUs")
     */
    public function aboutUs(EntityManagerInterface $em, Request $request): Response
    {
        if ($request->getMethod() == "POST") {

            $nom = $request->request->get("nom");
            $duree = $request->request->get("duree");
            $prix = $request->request->get("prix");


            // CREATION DE L'OBJET
            $offre = new Offres();
            $offre->setNom($nom)
                ->setDuree($duree)
                ->setPrix($prix);

            //AJOUT DANS BDD
            $em->persist($offre);
            $em->flush();
        }

        return $this->render('main/offres.html.twig', [
            'controller_name' => 'BucketController',
        ]);

    }

    /**
     * @Route("/main",name="app_aboutUs")
     */
    public function listeClient(OffresRepository $offreRepo): Response
    {
        $offres = $offreRepo->findAll();
        dump($offres);
        return $this->render("main/offres.html.twig",compact("offres"));
    }
}
