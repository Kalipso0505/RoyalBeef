<?php

declare(strict_types=1);

namespace App\Service;

use App\Kernel;

/**
 * Class CsvLoaderService
 * @package App\Service
 */
class CsvLoaderService
{
    public static function games(string $rootDir, int $year)
    {
           self::keyValue($rootDir,$year);
    }

    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @return array
     */
    private static function keyValue(string $rootDir, int $year): array
    {
        $result = [];
        ini_set('auto_detect_line_endings', '1');
        $handle =    fopen($rootDir . $year . '/list.csv', 'rb');
        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            $result[$data[0]] = $data[1];
        }
        ini_set('auto_detect_line_endings', '0');

        return $result;
    }

    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @return array
     */
    public static function singleCol(string $rootDir, int $year): array
    {
        $result = [];
        ini_set('auto_detect_line_endings', '1');
        $handle =    fopen($rootDir . $year . '/list.csv', 'rb');
        if ( ($data = fgetcsv($handle) ) !== FALSE ) {
            $result = $data;
        }
        ini_set('auto_detect_line_endings', '0');

        return $result;
    }
}