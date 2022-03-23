<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientType;
use App\Repository\ClientsRepository;
use App\Service\Censurator;
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
    public function index(Censurator $censure, EntityManagerInterface $em, Request $request): Response // OBTENIR MANAGER INTERFACE
    {

        if ($this->isGranted("ROLE_USER")) {


            // CREATION DE L'OBJET
            $client = new Clients();

            // CREATION FORMULAIRE
            $formClient = $this->createForm(ClientType::class, $client);

            // AJOUT DONNEES
            $formClient->handleRequest($request);

            if ($formClient->isSubmitted() && $formClient->isValid()) {

                // AJOUT DANS BDD
                $grosmot = array("Hitler","Zemmour","lepen","poutine","russie","ukraine");



                // RENVOIE A L4ACCUEIL AVEC UN MESSAGE QUAND RESERVE AVEC UN PRENOM OU NOM INTERDIT
               if ( in_array($client->getPrenom(),$grosmot)){
                    return $this->render("bucket/index.html.twig", [
                       "error"=>"IL TE FAUT UN PRENOM CORRECT, PETIT CON !"
                   ]);

               }
                if ( in_array($client->getNom(),$grosmot)){
                    return $this->render("bucket/index.html.twig", [
                        "error"=>"IL TE FAUT UN NOM CORRECT, PETIT CON !"
                    ]);

                }

                // CENSURE DES MOTS
                $client->setPrenom($censure->purify($client->getPrenom()));
                $client->setNom($censure->purify($client->getNom()));

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
        }else{
            return $this->redirectToRoute("app_login");
        }





    }

    /**
     * @Route("/listeClient",name="app-listeClient")
     */
    public function listeClient(ClientsRepository $clientRepo): Response
    {
        if ($this->isGranted("ROLE_USER")){

            $clients = $clientRepo->findAll();
            // $clients = $clientRepo->findBy(array('id'=>1)); // SELECT BY ID
            dump($clients);
            return $this->render("clients/listeClient.html.twig", compact("clients"));
        }
        return $this->redirectToRoute("app_login");
    }

    /**
     * @Route("/resultat",name="app-resultat")
     */
    public function resultat(ClientsRepository $clientRepo): Response{
        return $this->render("clients/resultat.html.twig");
    }

    /**
     * @Route("/supp", name="app_supp_client")
     */
    public function removeClient(ClientsRepository $clientRepo,Request $request):Response
    {
        $submittedToken = $request->request->get("token");

        if($this->isCsrfTokenValid('delete-item', $submittedToken)){
            $client = $clientRepo->find($request->request->get("id"));
            $clientRepo->remove($client);
        }

        return $this->redirectToRoute("app-listeClient");
       // return $this->json($this->isCsrfTokenValid('delete-item', $submittedToken)); RETURN JQUERY
    }
}
