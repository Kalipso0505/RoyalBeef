<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class BeefDataRepository
 * @package App\Service
 */
class BeefDataRepository
{
    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @return array
     */
    public static function games(string $rootDir, int $year): array
    {
        return self::keyValue($rootDir, $year, 'list');
    }

    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @return array
     */
    public static function player(string $rootDir, int $year): array
    {
        return self::singleCol($rootDir, $year, 'player');
    }

    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @param string $file
     *
     * @return array
     */
    private static function keyValue(string $rootDir, int $year, string $file): array
    {
        $result = [];
        ini_set('auto_detect_line_endings', '1');
        $handle = fopen($rootDir . $year . '/' . $file . '.csv', 'rb');
        while (($data = fgetcsv($handle)) !== false) {
            $result[$data[0]] = $data[1];
        }
        ini_set('auto_detect_line_endings', '0');

        return $result;
    }

    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @param string $file
     *
     * @return array
     */
    private static function singleCol(string $rootDir, int $year, string $file): array
    {
        $result = [];
        ini_set('auto_detect_line_endings', '1');
        $handle = fopen($rootDir . $year . '/' . $file . '.csv', 'rb');
        while (($data = fgetcsv($handle)) !== false) {
            $result[] = $data[0];
        }
        ini_set('auto_detect_line_endings', '0');

        return $result;
    }
}