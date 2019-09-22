<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\MatchMaker;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MatchMakerlTest extends TestCase
{
    public function testOneOnOne()
    {
        #dd(MatchMaker::OneOnOne(['Kalipso', 'Joni']));
    }
}
