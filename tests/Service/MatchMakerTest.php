<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\MatchMaker;
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
            ['Round 1', 'a', 'b'],
            ['Round 2', 'a', 'c'],
            ['Round 3', 'b', 'c']
        ];
        $this->assertSame($gamePlanExpected, $gamePlan);

    }

    public function testTwoPlayerCompeteWithFour(): void
    {
        $playerList = ['a', 'b', 'c', 'd'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 2);

        $gamePlanExpected = [
            ['Round 1', 'a', 'b'],
            ['Round 2', 'a', 'c'],
            ['Round 3', 'a', 'd'],
            ['Round 4', 'b', 'c'],
            ['Round 5', 'b', 'd'],
            ['Round 6', 'c', 'd'],
        ];
        $this->assertSame($gamePlanExpected, $gamePlan);

    }

    public function testThreePlayerCompeteWithFour(): void
    {
        $playerList = ['a', 'b', 'c', 'd'];
        $gamePlan   = MatchMaker::createGamePlan($playerList, 3);
dd($gamePlan);
        $gamePlanExpected = [
            ['Round 1', 'a', 'b', 'c'],
            ['Round 2', 'a', 'd', 'c'],
            ['Round 3', 'a', 'b', 'd'],
            ['Round 4', 'b', 'c', 'd'],
        ];
        $this->assertSame($gamePlanExpected, $gamePlan);

    }
}
