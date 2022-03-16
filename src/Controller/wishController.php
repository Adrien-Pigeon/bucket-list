<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class wishController extends AbstractController
{
    /**
     * @Route("/detail", name="app_detail")
     */
    public function detail(): Response
    {
        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'wishController',
        ]);
    }
}
