<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamePlanController extends AbstractController
{
    /**
     * @Route("/game/plan/{game}/{type}/", name="game_plan")
     * @param string $game
     * @param string $type
     *
     * @return Response
     */
    public function index(string $game, string $type): Response
    {
        $game = urldecode($game);
        dd($game, $type);
        return $this->render('game_plan/index.html.twig', [
            'game' => $game,
        ]);
    }
}
