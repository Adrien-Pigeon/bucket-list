<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

class ClientsController extends AbstractController
{
    /**
     * @Route("/clients", name="app_clients")
     */
    public function index(EntityManagerInterface $em, Request $request): Response // OBTENIR MANAGER INTERFACE
    {
        // CREATION DE L'OBJET
        $client = new Clients();

        // CREATION FORMULAIRE
        $formClient = $this->createForm(ClientType::class, $client);

        // AJOUT DONNEES
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {

            // AJOUT DANS BDD
            $em->persist($client);
            $em->flush();
            $this->addFlash("Succes","Reservation Faite !");
            return $this->redirectToRoute('app-resultat');

            // AUTRE VERSION CREATION DE L'OBJET
//          $client = new Clients();
//           $client->setPrenom($nom)
//              ->setNom($prenom)
//               ->setAge($age)
//              ->setDateReservation(new \DateTime($dateReservation));

            // ANCIEN AJOUT DONNEES

//          $nom = $request->request->get("nom");
//          $prenom = $request->request->get("prenom");
//          $age = $request->request->get("age");
//          $dateReservation = $request->request->get("dateReservation");


        }

        return $this->render("clients/reservation.html.twig", [
            'formClient' => $formClient->createView()
        ]);

    }

    /**
     * @Route("/listeClient",name="app-listeClient")
     */
    public function listeClient(ClientsRepository $clientRepo): Response
    {
        $clients = $clientRepo->findAll();
        // $clients = $clientRepo->findBy(array('id'=>1)); // SELECT BY ID
        dump($clients);
        return $this->render("clients/listeClient.html.twig", compact("clients"));
    }

    /**
     * @Route("/resultat",name="app-resultat")
     */
    public function resultat(ClientsRepository $clientRepo): Response{
        return $this->render("clients/resultat.html.twig");
    }
}
