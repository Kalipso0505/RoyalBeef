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
     */
    public function index(int $year, string $game, string $type): Response
    {
        $game = urldecode($game);
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';
        $playerList = BeefDataRepository::player($beefDataPath, $year);

        switch ($type) {
            case '4p': $matchMakingTable = MatchMaker::fourCompete($playerList);break;
            case '1p': $matchMakingTable = MatchMaker::oneOnOne($playerList); break;

            default: $matchMakingTable = MatchMaker::oneOnOne($playerList);
        }

        return $this->render('game_plan/index.html.twig', [
            'game' => $game,
            'gamePlan' => $matchMakingTable
        ]);
    }
}
