<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class ScoreService
 */
class ScoreService
{
    public static function store(string $path, int $year, string $game, array $data): bool
    {
        $gameResultPath = "$path$year/$game.csv";

        $success = file_put_contents($gameResultPath, json_encode($data));

        return $success !== false;
    }

    /*
    public static function store(string $path, int $year, string $game, array $data): bool
    {
        $gameResultPath = "$path$year/$game.csv";
        $fp  = fopen($gameResultPath, 'wb+');

        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        return true;
    }*/

    public static function load(string $path, int $year, string $game): array
    {
        $gameResultPath = "$path$year/$game.csv";

        return json_decode(file_get_contents($gameResultPath), true);
    }

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
}
