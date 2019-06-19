<?php


namespace Tests\Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\Movement;
use TicTacToe\Domain\User\User;

class GameStatusResponseTest extends TestCase
{
    private function gameFinished(): Game
    {
        $user1 = User::create('user1');
        $game = Game::start($user1, User::create('user2'));

        while (!$game->isFinished()) {
            $game->userMoves($user1->id(), new Movement('right'));
        }

        return $game;
    }

    public function testWhenGameStatusResponseIsCreatedFromAGameObjectItHasAllDataParsed()
    {
        $game = Game::start(
            User::create('user1'),
            User::create('user2')
        );

        $gameStatusResponse = GameStatusResponse::createFromGame($game);

        $this->assertNull($gameStatusResponse->winnerId());
        $this->assertNull($gameStatusResponse->winnerName());
        $this->assertFalse($gameStatusResponse->isFinished());
    }

    public function testWhenGameStatusResponseIsCreatedFromAFinishedGameObjectItHasAllDataParsed()
    {
        $gameStatusResponse = GameStatusResponse::createFromGame($this->gameFinished());

        $this->assertIsString($gameStatusResponse->winnerId());
        $this->assertIsString($gameStatusResponse->winnerName());
        $this->assertTrue($gameStatusResponse->isFinished());
    }
}