<?php

namespace App\Controller;

use App\Service\BeefDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function index(): Response
    {
        $beefDataPath = $this->getParameter('kernel.root_dir') . '/../games/';

        $player = BeefDataRepository::player($beefDataPath, 2019);

        return $this->render('welcome/index.html.twig', [
            'avatars1' => $player,
            'avatars2' => $this->merryGoRound($player),
            'avatars3' => $this->merryGoRound($player),
            'avatars4' => $this->merryGoRound($player),
            'avatars5' => $this->merryGoRound($player),
            'avatars6' => $this->merryGoRound($player),
        ]);
    }

    /**
     * @param array $player
     *
     * @return array
     */
    public function merryGoRound(array &$player): array
    {
        $player[] = array_shift($player);

        return $player;
    }
}
