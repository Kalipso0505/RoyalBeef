<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ScoreService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ScoreServiceTest extends TestCase
{
    public function testLoadNotExisting(): void
    {
        self::assertEquals([], ScoreService::load(__DIR__ . '/../data/games/123', 'existiertNicht'));
    }

    public function testStore(): void
    {
        $input = $this->getTableData();

        ScoreService::store(__DIR__ . '/../data/games/123', 'spiel name', $input);

        $this->assertFileExists(__DIR__ . '/../data/games/' . 123 . '/gameSpiel_name.json');

        self::assertEquals($input, ScoreService::load(__DIR__ . '/../data/games/123/', 'spiel name'));
    }

    public function testResultExtract(): void
    {
        $scores           = $this->getTableData();
        $expected         = [
            'Chris'   => 17,
            'Rens'    => 14,
            'Joni'    => 13,
            'Baerti'  => 10,
            'Kos'     => 9,
            'Kalipso' => 9
        ];
        $extractUserScore = ScoreService::extractUserResults($scores, count($expected), count($expected));
        self::assertSame(ksort($expected), ksort($extractUserScore));
    }

    public function testOverallScore(): void
    {
        #self::assertEquals(ScoreService::extractOverallUserScore(['anderes spiel name', 'spiel name', 'spielname'], __DIR__ . '/../data/games/123'), []);
    }

    /**
     * @return array
     */
    private function getTableData(): array
    {
        return ['result' => [
            '1'  =>
                ['1' => ['Kalipso' => '1'],
                 '2' => ['Joni' => '2'],
                 '3' => ['Chris' => '3'],
                 '4' => ['Rens' => '4'],
                ],
            '2'  => [
                '1' => ['Kalipso' => '4'],
                '2' => ['Kos' => '3'],
                '3' => ['Chris' => '2'],
                '4' => ['Rens' => '1'],
            ],
            '3'  => [
                '1' => ['Kalipso' => '3',],
                '2' => ['Joni' => '2'],
                '3' => ['Kos' => '1'],
                '4' => ['Rens' => '4'],
            ],
            '4'  => [
                '1' => ['Kalipso' => '2'],
                '2' => ['Joni' => '1'],
                '3' => ['Chris' => '3'],
                '4' => ['Kos' => '4'],
            ],
            '5'  => [
                '1' => ['Kalipso' => '1'],
                '2' => ['Bärti' => '2'],
                '3' => ['Chris' => '3'],
                '4' => ['Rens' => '4'],
            ],
            '6'  => [
                '1' => ['Kalipso' => '2'],
                '2' => ['Joni' => '3'],
                '3' => ['Bärti' => '4'],
                '4' => ['Rens' => '1'],
            ],
            '7'  => [
                '1' => ['Kalipso' => '3'],
                '2' => ['Joni' => '4'],
                '3' => ['Chris' => '1'],
                '4' => ['Bärti' => '2'],
            ],
            '8'  => [
                '1' => ['Joni' => '4'],
                '2' => ['Chris' => '3'],
                '3' => ['Rens' => '2'],
                '4' => ['Kos' => '1'],
            ],
            '9'  => [
                '1' => ['Joni' => '1'],
                '2' => ['Bärti' => '2'],
                '3' => ['Rens' => '3'],
                '4' => ['Kos' => '4'],
            ],
            '10' => [
                '1' => ['Joni' => '2'],
                '2' => ['Chris' => '3'],
                '3' => ['Bärti' => '4'],
                '4' => ['Kos' => '1'],
            ],
            '11' => [
                '1' => ['Joni' => '3'],
                '2' => ['Chris' => '4'],
                '3' => ['Rens' => '1'],
                '4' => ['Bärti' => '2'],
            ],
            '12' => [
                '1' => ['Chris' => '4'],
                '2' => ['Rens' => '3'],
                '3' => ['Kos' => '2'],
                '4' => ['Bärti' => '1'],
            ],
        ],
        ];
    }
}
