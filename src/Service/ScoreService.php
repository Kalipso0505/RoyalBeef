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
     * @param int $maxScore
     * @return array
     */
    public static function extractUserResults(array $data, int $maxScore): array
    {
        $result = [];
        array_walk_recursive($data, static function ($position, $player) use (&$result, $maxScore) {
            if (!is_array($position) && $position !== '') {
                $score = $maxScore - $position;
                if (!array_key_exists($player, $result)) {
                    $result[$player]['score'] = $score;
                    $result[$player]['positions'][$position] = 1;
                } else {
                    $result[$player]['score'] += $score;
                    array_key_exists($position, $result[$player]['positions']) ?
                        ++$result[$player]['positions'][$position] :
                        $result[$player]['positions'][$position] = 1;
                }
            }
        });
        arsort($result);
        return $result;
    }

    /**
     * @param array $games
     * @param string $beefDataPath
     * @param int $playerCount
     * @return array
     */
    public static function extractOverallUserScore(array $games, string $beefDataPath, int $playerCount): array
    {
        $result = [];
        foreach (array_keys($games) as $game) {
            $gamerPerField = (int)rtrim($games[$game], 'p');
            $maxPoints = $gamerPerField === 1 ? $playerCount : $gamerPerField;
            $scores = self::extractUserResults(self::load($beefDataPath, $game), $maxPoints);
            foreach ($scores as $player => $score) {
                if(array_key_exists($player,$result)) {
                    $result[$player]['score'] += $score['score'] ?? 0;
                    $result[$player]['positions'] = self::arraySum($score['positions'] ?? [], $result[$player]['positions'] ?? []);
                } else {
                    $result[$player]['score'] = $score['score'] ;
                    $result[$player]['positions'] = $score['positions'];
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
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private static function arraySum(array $array1, array $array2)
    {
        $result = [];
        $keys = array_merge(array_keys($array1), array_keys($array2));
        asort($keys);
        foreach ($keys as $key) {
            $result[$key] = ($array1[$key] ?? 0) + ($array2[$key] ?? 0);
        }
        return $result;
    }
}
