<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ScoreService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ScoreServiceTest extends TestCase
{
    public function testLoadNotExisting()
    {
        self::assertEquals([], ScoreService::load(__DIR__ . '/../data/games/', 123, 'existiertNicht'));
    }

    public function testStore()
    {
        $input = $this->getTableData();

        ScoreService::store(__DIR__ . '/../data/games/', 123, 'spiel name', $input);

        $this->assertFileExists(__DIR__ . '/../data/games/' . 123 . '/gameSpiel_name.json');

        self::assertEquals($input, ScoreService::load(__DIR__ . '/../data/games/', 123, 'spiel name'));
    }

    public function testScoreExtract()
    {
        $scores = $this->getTableData();
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

    /**
     * @return array
     */
    private function getTableData(): array
    {
        return ['result' => [
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
    }
}
