<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\MatchMaker;
use Exception;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

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
        $this->assertSame($gamePlanExpected, $gamePlan);
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
        $this->assertSame($gamePlanExpected, $gamePlan);
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
        $this->assertSame($gamePlanExpected, $gamePlan);
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
        $this->assertSame($gamePlanExpected, $gamePlan);
    }

    public function testFourPlayerCompeteWithSix(): void
    {
        $playerList = ['a', 'b', 'c', 'd', 'e', 'f'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 4);

        $gamePlanExpected = [
            ['Player 1', 'Player 2', 'Player 3', 'Player 4'],
            ['a', 'b', 'c', 'd'],
            ['a', 'e', 'c', 'd'],
            ['a', 'b', 'e', 'd'],
            ['a', 'b', 'c', 'e'],
            ['a', 'f', 'c', 'd'],
            ['a', 'b', 'f', 'd'],
            ['a', 'b', 'c', 'f'],
            ['b', 'c', 'd', 'e'],
            ['b', 'f', 'd', 'e'],
            ['b', 'c', 'f', 'e'],
            ['b', 'c', 'd', 'f'],
            ['c', 'd', 'e', 'f'],
        ];
        $this->assertSame($gamePlanExpected, $gamePlan);
    }
}
