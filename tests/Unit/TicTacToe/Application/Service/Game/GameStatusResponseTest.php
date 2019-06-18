<?php


namespace Tests\Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;

class GameStatusResponseTest extends TestCase
{
    public function testWhenGameStatusResponseIsCreatedFromAGameObjectItHasAllDataParsed()
    {
        $game = Game::start(
            User::create('user1'),
            User::create('user2')
        );

        $gameStatusResponse = GameStatusResponse::createFromGame($game);

        $this->assertNull($gameStatusResponse->winnerId());
        $this->assertFalse($gameStatusResponse->isFinished());
    }
}