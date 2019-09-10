<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig', [
            'avatars1' => ['kalipso', 'joni', 'chris', 'rens', 'kos', 'baerti'],
            'avatars2' => ['joni', 'chris', 'rens', 'kos', 'baerti', 'kalipso'],
            'avatars3' => ['chris', 'rens', 'kos', 'baerti', 'kalipso', 'joni'],
            'avatars4' => ['rens', 'kos', 'baerti', 'kalipso', 'joni', 'chris'],
            'avatars5' => ['kos', 'baerti', 'kalipso', 'joni', 'chris', 'rens'],
            'avatars6' => ['baerti', 'kalipso', 'joni', 'chris', 'rens', 'kos'],
        ]);
    }
}
