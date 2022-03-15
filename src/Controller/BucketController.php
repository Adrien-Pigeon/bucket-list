<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function aboutUs(): Response
    {
        return $this->render('main/about-us.html.twig', [
            'controller_name' => 'BucketController',
        ]);
    }
}
