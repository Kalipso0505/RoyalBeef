<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use App\Service\MatchMaker;
use App\Service\ScoreService;
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
        if (!empty($_REQUEST)) {
            // todo aktualisieren der csv daten
        }
        print_r($_REQUEST);
        $game         = urldecode($game);
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';
        $playerList   = BeefDataRepository::player($beefDataPath, $year);
        $playerList   = array_map(static function ($item) {
            return ucfirst(str_replace('ae', 'ä', $item));
        }, $playerList);

        $gamerPerField    = rtrim($type, 'p');
        $matchMakingTable = MatchMaker::createGamePlan($playerList, $gamerPerField);

        $result = $_REQUEST['result'];

        return $this->render('game_plan/index.html.twig', [
            'game'      => $game,
            'gamePlan'  => $matchMakingTable,
            'score'     => $result,
            'maxPoints' => $gamerPerField - 1,
            'sumScore' => ScoreService::extractUserScore($result)
        ]);
    }
}
