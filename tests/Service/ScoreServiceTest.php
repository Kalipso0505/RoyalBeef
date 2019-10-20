<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ScoreService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ScoreServiceTest extends TestCase
{
    public function testStore()
    {
        $input = [
            ['11' => '1a', '12' => '1b', '13' => '1c', '14' => '1d'],
            ['21' => '2a', '22' => '2b', '23' => '2c', '24' => '2d'],
            ['31' => '3a', '32' => '3b', '33' => '3c', '34' => '3d'],
            ['41' => '4a', '42' => '4b', '43' => '4c', '44' => '4d'],
            ['51' => '5a', '52' => '5b', '53' => '5c', '54' => '5d'],
            ['61' => '6a', '62' => '6b', '63' => '6c', '64' => '6d'],
            ['71' => '7a', '72' => '7b', '73' => '7c', '74' => '7d'],
            ['81' => '8a', '82' => '8b', '83' => '8c', '84' => '8d'],
            ['91' => '9a', '92' => '9b', '93' => '9c', '94' => '9d'],
            ['101' => '10a', '102' => '10b', '103' => '10c', '104' => '10d'],
            ['111' => '11a', '112' => '11b', '113' => '11c', '114' => '11d'],
            ['121' => '12a', '122' => '12b', '123' => '12c', '124' => '12d'],
        ];

        $a = ScoreService::store(__DIR__ . '/../data/games/', 123, 'spielname', $input);

        $this->assertFileExists(__DIR__ . '/../data/games/' . 123);
    }

    public function testScoreExtract()
    {
        $scores = ['result' => [
            '1'  =>
                ['1' => ['Kalipso' => '0'],
                 '2' => ['Joni' => '1'],
                 '3' => ['Chris' => '2'],
                 '4' => ['Rens' => '3'],
                ],
            '2'  => [
                '1' => ['Kalipso' => '3'],
                '2' => ['Kos' => '2'],
                '3' => ['Chris' => '1'],
                '4' => ['Rens' => '0'],
            ],
            '3'  => [
                '1' => ['Kalipso' => '2',],
                '2' => ['Joni' => '1'],
                '3' => ['Kos' => '0'],
                '4' => ['Rens' => '3'],
            ],
            '4'  => [
                '1' => ['Kalipso' => '1'],
                '2' => ['Joni' => '0'],
                '3' => ['Chris' => '2'],
                '4' => ['Kos' => '3'],
            ],
            '5'  => [
                '1' => ['Kalipso' => '0'],
                '2' => ['Bärti' => '1'],
                '3' => ['Chris' => '2'],
                '4' => ['Rens' => '3'],
            ],
            '6'  => [
                '1' => ['Kalipso' => '1'],
                '2' => ['Joni' => '2'],
                '3' => ['Bärti' => '3'],
                '4' => ['Rens' => '0'],
            ],
            '7'  => [
                '1' => ['Kalipso' => '2'],
                '2' => ['Joni' => '3'],
                '3' => ['Chris' => '0'],
                '4' => ['Bärti' => '1'],
            ],
            '8'  => [
                '1' => ['Joni' => '3'],
                '2' => ['Chris' => '2'],
                '3' => ['Rens' => '1'],
                '4' => ['Kos' => '0'],
            ],
            '9'  => [
                '1' => ['Joni' => '0'],
                '2' => ['Bärti' => '1'],
                '3' => ['Rens' => '2'],
                '4' => ['Kos' => '3'],
            ],
            '10' => [
                '1' => ['Joni' => '1'],
                '2' => ['Chris' => '2'],
                '3' => ['Bärti' => '3'],
                '4' => ['Kos' => '0'],
            ],
            '11' => [
                '1' => ['Joni' => '2'],
                '2' => ['Chris' => '3'],
                '3' => ['Rens' => '0'],
                '4' => ['Bärti' => '1'],
            ],
            '12' => [
                '1' => ['Chris' => '3'],
                '2' => ['Rens' => '2'],
                '3' => ['Kos' => '1'],
                '4' => ['Bärti' => '0'],
            ],
        ],
        ];
        $expected = [
            'Bäerti' => 10,
            'Kos' => 9,
            'Rens' => 14,
            'Joni' => 13,
            'Chris' => 17,
            'Kalipso' => 9
        ];
        $extractUserScore = ScoreService::extractUserScore($scores);
        self::assertSame(ksort($expected), ksort($extractUserScore));
    }
}
