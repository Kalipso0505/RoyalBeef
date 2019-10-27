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
     * @param int    $year
     * @param string $game
     * @param array  $data
     *
     * @return bool
     */
    public static function store(string $path, int $year, string $game, array $data): bool
    {
        $game = self::game2FileName($game);
        $gameResultPath = "$path$year/$game.json";

        $success = file_put_contents($gameResultPath, json_encode($data));

        return $success !== false;
    }

    /**
     * @param string $path
     * @param int    $year
     * @param string $game
     *
     * @return array
     */
    public static function load(string $path, int $year, string $game): array
    {
        $game = self::game2FileName($game);
        $gameResultPath = "$path$year/$game.json";
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
     * @param $data
     *
     * @return array
     */
    public static function extractUserScore($data): array
    {
        $result = [];
        array_walk_recursive($data, static function ($item, $key) use (&$result) {
            if (!is_array($item)) {
                if (!array_key_exists($key, $result)) {
                    $result[$key] = 0;
                }
                $result[$key] += (int) $item;
            }
        });

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
}
