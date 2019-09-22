<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class matchMaker
 * @package App\Service
 */
class MatchMaker
{
    /**
     * @param array $playerList
     *
     * @return array
     */
    public static function oneOnOne(array $playerList): array
    {
        $result      = [];
        $headline[]  = '#';
        $playerCount = count($playerList);
        $playerList  = array_map('ucfirst', $playerList);

        foreach ($playerList as $key => $player) {
            $headline[] = $player;
            $emptyList  = array_fill(0, $playerCount, '');
            array_unshift($emptyList, $player);
            $result[$key] = $emptyList;
        }

        array_unshift($result, $headline);

        return $result;
    }

    public static function fourCompete(array $playerList): array
    {
        $playerPerField = 4;
        $match          = self::createGameField($playerList, $playerPerField);

        $combinations = $playerPerField * count($playerList);
    }

    public static function createGamePlan(array $playerList, int $gamerPerField): array
    {
        $result  = [];
        $roundNr = 1;

        while($firstPlayer = array_shift($playerList)) {
            foreach ($playerList as $player) {
                $result[] = ['Round ' . $roundNr++, $firstPlayer, $player];
            }
        }

        return $result;
    }

    private static function createGameField(array $playerList, int $gamerPerField): array
    {
        $result = [];
        for ($i = 0; $i < $gamerPerField; ++$i) {
            $result[] = array_shift($playerList);
        }

        return $result;
    }
}

# # a  b  c
# a '' '' ''
# c '' '' ''


