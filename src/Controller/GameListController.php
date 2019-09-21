<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameListController extends AbstractController
{
    /**
     * @Route("/game/list/{year}", name="game_list")
     * @param int $year
     *
     * @return Response
     */
    public function index(int $year): Response
    {
        $beefDatapath = $this->getParameter('kernel.root_dir') . '/../games/';
        //dd(BeefDataRepository::load($beefDatapath, $year));
        return $this->render('game_list/index.html.twig', [
            'year' => $year,
            'gameList' => BeefDataRepository::games($beefDatapath, $year),
        ]);
    }
}
