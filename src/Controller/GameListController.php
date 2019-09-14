<?php

namespace App\Controller;

use App\Service\GameLoaderService;
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
        $gameListpath = $this->getParameter('kernel.root_dir') . '/../games/';
        //dd($gameListpath);
        return $this->render('game_list/index.html.twig', [
            'year' => $year,
            'gameList' => GameLoaderService::load($gameListpath, $year),
        ]);
    }
}
