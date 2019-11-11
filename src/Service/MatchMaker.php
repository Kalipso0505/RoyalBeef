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

        foreach ($playerList as $key => $player) {
            $headline[] = $player;
            $emptyList  = array_fill(0, $playerCount, '');
            array_unshift($emptyList, $player);
            $result[$key] = $emptyList;
        }

        array_unshift($result, $headline);

        return $result;
    }

    public static function createGamePlan(array $playerList, int $gamerPerField): array
    {
        if (count($playerList) < $gamerPerField) {
            throw new \Exception('Too few player for this game.');
        }

        $roundNr = 1;
        $result  = self::createGameRows($playerList, $gamerPerField, $roundNr);
        if (count($playerList) == $gamerPerField) {
            for($i=1; $i<4; ++$i) {
                $result = array_merge($result, self::createGameRows($playerList, $gamerPerField, $roundNr));
            }
        }
        $headline = [];
        if ($gamerPerField === 1) {
            $headline[] = 'Position';
        } else {
            for ($i = 1; $i <= $gamerPerField; $i++) {
                $headline[] = 'Player ' . $i;
            }
        }

        array_unshift($result, $headline);

        return $result;
    }

    private static function createGameRows(array $playerList, int $gamerPerField, int &$roundNr = 1): array
    {
        $starters = array_slice($playerList, 0, $gamerPerField);
        $rest     = array_slice($playerList, $gamerPerField, count($playerList));

        $result   = [];
        $result[] = self::createRow($starters, $roundNr);

        foreach ($rest as $player) {
            for ($i = 1; $i < $gamerPerField; $i++) {
                $newRow     = $starters;
                $newRow[$i] = $player;
                $result[]   = self::createRow($newRow, $roundNr);
            }
        }

        array_shift($playerList);
        if (count($playerList) >= $gamerPerField) {
            $result = array_merge($result, self::createGameRows($playerList, $gamerPerField, $roundNr));
        }

        return $result;
    }

    /**
     * @param array $players
     * @param       $roundNr
     *
     * @return array
     */
    private static function createRow(array $players, &$roundNr): array
    {
        foreach ($players as $player) {
            $row[] = $player;
        }

        return $row;
    }
}


