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
    public static function OneOnOne(array $playerList): array
    {
        $result      = [];
        $headline[]  = '#';
        $playerCount = count($playerList);
        $playerList = array_map('ucfirst', $playerList);

        foreach ($playerList as $key => $player) {
            $headline[]     = $player;
            $emptyList      = array_fill(0, $playerCount, '');
            array_unshift($emptyList, $player);
            $result[$key] = $emptyList;
        }

        array_unshift($result, $headline);

        return $result;
    }
}

# # a  b  c
# a '' '' ''
# c '' '' ''