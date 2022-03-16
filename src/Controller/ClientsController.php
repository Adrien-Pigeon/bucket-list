<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends AbstractController
{
    /**
     * @Route("/clients", name="app_clients")
     */
    public function index(EntityManagerInterface $em, Request $request): Response // OBTENIR MANAGER INTERFACE
    {
       if ($request->getMethod()=="POST") {

           $nom = $request->request->get("nom");
           $prenom = $request->request->get("prenom");
           $age = $request->request->get("age");
           $dateReservation = $request->request->get("dateReservation");

           // CREATION DE L'OBJET
           $client = new Clients();
           $client->setPrenom($nom)
               ->setNom($prenom)
               ->setAge($age)
               ->setDateReservation(new \DateTime($dateReservation));

           //AJOUT DANS BDD
           $em->persist($client);
           $em->flush();

       }

        return $this->render("clients/reservation.html.twig");

    }

    /**
     * @Route("/listeClient",name="app-listeClient")
     */
    public function listeClient(ClientsRepository $clientRepo): Response
    {
        $clients = $clientRepo->findAll();
        dump($clients);
        return $this->render("clients/listeClient.html.twig",compact("clients"));
    }
}
