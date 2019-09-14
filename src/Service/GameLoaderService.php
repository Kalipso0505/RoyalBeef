<?php

declare(strict_types=1);

namespace App\Service;

use App\Kernel;

/**
 * Class GameLoaderService
 * @package App\Service
 */
class GameLoaderService
{
    /**
     * @param string $rootDir
     * @param int    $year
     *
     * @return array
     */
    public static function load(string $rootDir, int $year): array
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
}