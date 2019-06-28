<?php


namespace Tests\Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;

class GameStatusResponseTest extends TestCase
{
    private function gameFinished(): Game
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');
        $game = Game::start($user1, $user2);

        $game->userMoves($user1->id(), 1);
        $game->userMoves($user2->id(), 4);
        $game->userMoves($user1->id(), 2);
        $game->userMoves($user2->id(), 5);
        $game->userMoves($user1->id(), 3);

        return $game;
    }

    public function testWhenGameStatusResponseIsCreatedFromAGameObjectItHasAllDataParsed()
    {
        $game = Game::start(
            $user1 = User::create('user1'),
            $user2 = User::create('user2')
        );

        $gameStatusResponse = GameStatusResponse::createFromGame($game);

        $this->assertEmpty($gameStatusResponse->winner());
        $this->assertEquals(['id' => $user1->id(), 'name' => $user1->name()], $gameStatusResponse->firstUser());
        $this->assertEquals(['id' => $user2->id(), 'name' => $user2->name()], $gameStatusResponse->secondUser());
        $this->assertFalse($gameStatusResponse->isFinished());
    }

    public function testWhenGameStatusResponseIsCreatedFromAFinishedGameObjectItHasAllDataParsed()
    {
        $gameStatusResponse = GameStatusResponse::createFromGame($this->gameFinished());

        $this->assertNotEmpty($gameStatusResponse->winner());
        $this->assertArrayHasKey('id', $gameStatusResponse->winner());
        $this->assertArrayHasKey('name', $gameStatusResponse->winner());
        $this->assertTrue($gameStatusResponse->isFinished());
    }
}