<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use App\Service\MatchMaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePlanController extends AbstractController
{
    /**
     * @Route("/game/plan/{year}/{game}/{type}/", name="game_plan")
     * @param int    $year
     * @param string $game
     * @param string $type
     *
     * @return Response
     * @throws \Exception
     */
    public function index(int $year, string $game, string $type): Response
    {
        $game = urldecode($game);
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';
        $playerList = BeefDataRepository::player($beefDataPath, $year);
        $playerList  = array_map(function($item) {
            return ucfirst(str_replace('ae', 'ä', $item));
        }, $playerList);

        $matchMakingTable = MatchMaker::createGamePlan($playerList, rtrim($type, 'p'));

        return $this->render('game_plan/index.html.twig', [
            'game' => $game,
            'gamePlan' => $matchMakingTable
        ]);
    }
}
