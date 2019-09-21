<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
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
        $gamer = BeefDataRepository::player($beefDataPath, $year);
        dd($game, $type, $gamer);
        return $this->render('game_plan/index.html.twig', [
            'game' => $game,
            'year' => $year
        ]);
    }
}
