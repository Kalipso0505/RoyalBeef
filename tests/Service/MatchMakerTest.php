<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\MatchMaker;
use Exception;
use PHPUnit\Framework\TestCase;

class MatchMakerTest extends TestCase
{
    public function testOneOnOne(): void
    {
        $playerList = ['a', 'b', 'c'];
        $gamePlan   = MatchMaker::OneOnOne($playerList);

        $this->assertCount(count($playerList) + 1, $gamePlan[0]);
        $this->assertCount(count($playerList) + 1, $gamePlan);
    }

    public function testTwoPlayerCompeteWithThree(): void
    {
        $playerList = ['a', 'b', 'c'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 2);

        $gamePlanExpected = [
            ['Player 1', 'Player 2'],
            ['a', 'b'],
            ['a', 'c'],
            ['b', 'c']
        ];

        self::check($gamePlanExpected, $gamePlan);
    }

    public function testTwoPlayerCompeteWithFour(): void
    {
        $playerList = ['a', 'b', 'c', 'd'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 2);

        $gamePlanExpected = [
            ['Player 1', 'Player 2'],
            ['a', 'b'],
            ['a', 'c'],
            ['a', 'd'],
            ['b', 'c'],
            ['b', 'd'],
            ['c', 'd'],
        ];

        self::check($gamePlan, $gamePlanExpected);
    }

    public function testToFewPlayers(): void
    {
        $this->expectException(Exception::class);

        $playerList = ['a', 'b'];
        MatchMaker::createGamePlan($playerList, 3);
    }

    public function testPlayerMatchesGameSlots(): void
    {
        $playerList = ['a', 'b'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 2);

        $gamePlanExpected = [
            ['Player 1', 'Player 2'],
            ['a', 'b'],
            ['a', 'b'], // additional game3 because all combinations were matched within one game
            ['a', 'b'],
            ['a', 'b'],
        ];

        self::check($gamePlan, $gamePlanExpected);
        self::assertCount(MatchMaker::GAME_COUNT_PLAYER_MATCHING + 1, $gamePlan);

    }

    public function testThreePlayerCompeteWithFour(): void
    {
        $playerList = ['a', 'b', 'c', 'd'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 3);
        $gamePlanExpected = [
            ['Player 1', 'Player 2', 'Player 3'],
            ['a', 'b', 'c'],
            ['a', 'd', 'c'],
            ['a', 'b', 'd'],
            ['b', 'c', 'd'],
        ];

        self::check($gamePlan, $gamePlanExpected);
    }

    public function testFourPlayerCompeteWithSix(): void
    {
        $playerList = ['a', 'b', 'c', 'd', 'e', 'f'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 4);

        $gamePlanExpected = [
            ['Player 1', 'Player 2', 'Player 3', 'Player 4'],
            ['a', 'b', 'c', 'd'],
            ['a', 'b', 'c', 'e'],
            ['a', 'b', 'c', 'f'],
            ['a', 'b', 'e', 'd'],
            ['a', 'b', 'e', 'f'],
            ['a', 'b', 'f', 'd'],
            ['a', 'c', 'e', 'f'],
            ['a', 'd', 'e', 'f'],
            ['a', 'e', 'c', 'd'],
            ['a', 'f', 'c', 'd'],
            ['b', 'c', 'd', 'e'],
            ['b', 'c', 'd', 'f'],
            ['b', 'c', 'f', 'e'],
            ['b', 'f', 'd', 'e'],
            ['c', 'd', 'e', 'f'],
        ];

        self::check($gamePlan, $gamePlanExpected);
    }

    private static function makeMultiArraySortable(array $unsorted)
    {
        $result = [];
        foreach ($unsorted as $key => $subarray) {
            asort($subarray);
            $result[] = implode('.', $subarray);
        }
        asort($result);

        return array_values($result);
    }

    /**
     * @param array $gamePlanExpected
     * @param array $gamePlan
     */
    private static function check(array $gamePlanExpected, array $gamePlan): void
    {
        $expected = self::makeMultiArraySortable($gamePlanExpected);
        $plan = self::makeMultiArraySortable($gamePlan);

        self::assertEquals([], array_diff($expected, $plan));
        self::assertEquals([], array_diff($plan, $expected));
        self::assertCount(count($expected), $plan);
    }
}
