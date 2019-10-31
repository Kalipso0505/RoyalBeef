<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class ScoreService
 */
class ScoreService
{
    /**
     * @param string $path
     * @param string $game
     * @param array  $data
     *
     * @return bool
     */
    public static function store(string $path, string $game, array $data): bool
    {
        $game           = self::game2FileName($game);
        $gameResultPath = "$path/$game.json";

        $success = file_put_contents($gameResultPath, json_encode($data));

        return $success !== false;
    }

    /**
     * @param string $path
     * @param string $game
     *
     * @return array
     */
    public static function load(string $path, string $game): array
    {
        $game           = self::game2FileName($game);
        $gameResultPath = "$path/$game.json";

        if (!file_exists($gameResultPath)) {
            return [];
        }

        $data = file_get_contents($gameResultPath);
        if ($data === false) {
            return [];
        }

        return json_decode($data, true);
    }

    /**
     * @param array $data
     *
     *
     * @return array
     */
    public static function extractUserResults(array $data): array
    {
        $result = [];
        array_walk_recursive($data, static function ($item, $key) use (&$result) {
            if (!is_array($item)) {
                $item = ($item === '') ? 0 : ((int) $item) - 1;
                if (!array_key_exists($key, $result)) {
                    $result[$key] = $item;
                } else {
                    $result[$key] += $item;
                }
            }
        });
        arsort($result);
        return $result;
    }

    public static function extractOverallUserScore(array $games, string $beefDataPath, int $playerInCompetition): array
    {
        $result = [];
        foreach ($games as $game) {
            $scores = self::addScore(
                self::extractUserResults(self::load($beefDataPath, $game)),
                $playerInCompetition,
                false
            );
            foreach ($scores as $player => $score) {
                if(array_key_exists($player,$result)) {
                    $result[$player] += $score ;
                } else {
                    $result[$player] = $score ;
                }
            }
        }

        return $result;
    }

    /**
     * @param string $game
     *
     * @return string
     */
    private static function game2FileName(string $game): string
    {
        return 'game' . ucfirst(str_replace(' ', '_', urldecode($game)));
    }

    /**
     * @param array $playersResults
     * @param int $playerInCompetition
     *
     * @param bool $apply
     * @return array
     */
    public static function addScore(array $playersResults, int $playerInCompetition, bool $apply): array
    {
        arsort($playersResults);
        $result     = [];
        $lastResult = 0;
        --$playerInCompetition;
        foreach ($playersResults as $player => $playersResult) {
            if ($playersResult < $lastResult) {
                --$playerInCompetition;
            }
            if($apply) {
                $result[$player]['result'] = $playersResult;
                $result[$player]['score'] = $playerInCompetition;
            } else {
                $result[$player] = $playerInCompetition;
            }
            $lastResult = $playersResult;
        }

        return $result;
    }
}
