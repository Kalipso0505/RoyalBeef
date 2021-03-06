<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use App\Service\MatchMaker;
use App\Service\RandomRoundService;
use App\Service\ScoreService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePlanController extends AbstractController
{
    /**
     * @Route("/game/plan/{year}/{game}/{type}/", name="game_plan")
     * @param int $year
     * @param string $game
     * @param string $type
     *
     * @return Response
     * @throws Exception
     */
    public function index(int $year, string $game, string $type): Response
    {
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';
        $game = urldecode($game);

        if (!empty($_REQUEST)) {
            $result = $_REQUEST['result'] ?? [];
            ScoreService::store($beefDataPath . $year, $game, $result);
        } else {
            $result = ScoreService::load($beefDataPath . $year, $game);
        }

        $playerList = BeefDataRepository::player($beefDataPath, $year);
        $playerList = array_map(static function ($item) {
            return ucfirst(str_replace('ae', 'ä', $item));
        }, $playerList);

        $gamerPerField = (int)rtrim($type, 'p');
        $maxPoints = $gamerPerField === 1 ? count($playerList) : $gamerPerField;

        $matchMakingTable = MatchMaker::createGamePlan($playerList, $gamerPerField);
        $extractUserResults = ScoreService::extractUserResults($result, $maxPoints, count($playerList));

        $unplayedMatches = RandomRoundService::get($result);
        return $this->render('game_plan/index.html.twig', [
            'game' => $game,
            'gamePlan' => $matchMakingTable,
            'score' => $result,
            'maxPoints' => $maxPoints,
            'gamerPerField' => $gamerPerField,
            'sumScore' => $extractUserResults,
            'random' => $unplayedMatches === [] ? count($matchMakingTable) : $unplayedMatches[array_rand($unplayedMatches)]
        ]);
    }
}
