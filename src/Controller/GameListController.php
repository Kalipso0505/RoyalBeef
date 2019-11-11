<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use App\Service\ScoreService;
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
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';
        $games = BeefDataRepository::games($beefDataPath, $year);
        $playerList = BeefDataRepository::player($beefDataPath, $year);

        $extractOverallUserScore = ScoreService::extractOverallUserScore(
            $games,
            $beefDataPath . $year . '/',
            count($playerList)
        );

        return $this->render('game_list/index.html.twig', [
            'year' => $year,
            'gameList' => $games,
            'sumScore' => $extractOverallUserScore
        ]);
    }
}

