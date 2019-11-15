<?php


namespace App\Service;


class RandomRoundService
{
    public static function get(array $scoreTable)
    {
        $result = [];
        if(count($scoreTable) !== 1) {
            return $result;
        }
        $scoreTable = current($scoreTable);
        foreach ($scoreTable as $nr => $round) {
            if(self::getScoreLevel($round) === '') {
                $result[] = $nr;
            }
        }
        return $result;
    }

    private static function getScoreLevel(array $data)
    {
        $result = null;
        $level = current($data);
        if (is_array($level)) {
            return self::getScoreLevel($level);
        }
        return $level;
    }
}