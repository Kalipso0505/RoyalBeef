<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\BeefDataRepository;
use PHPUnit\Framework\TestCase;

class GameLoaderServiceTest extends TestCase
{

    public function testLoad(): void
    {
        $result = BeefDataRepository::games(__DIR__ . '/../data/games/',123);
        $this->assertCount(3, $result);
        $this->assertSame(['Mario Card', 'Crazy Tetris', 'Worms'], array_keys($result));
    }
}
