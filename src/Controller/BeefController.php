<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeefController extends AbstractController
{
    /**
     * @Route("/beef", name="beef")
     */
    public function index(): Response
    {
        return $this->render('beef/index.html.twig', []);
    }
}
