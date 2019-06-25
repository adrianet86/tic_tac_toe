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

    public function testBoardStringIsWellFormed()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');
        $game = Game::start($user1, $user2);

        $expectedBoardString =
            "  |   |  \n"
            .   "  |   |  \n"
            .   "  |   |  \n"
            .   "\n" . $user1->name() . ': x'
            .   "\n" . $user2->name() . ': o'
        ;
        $gameStatusResponse = GameStatusResponse::createFromGame($game);
        $this->assertEquals($expectedBoardString, $gameStatusResponse->boardString());

        $expectedBoardString =
             "x |   |  \n"
            .   "  |   |  \n"
            .   "  |   |  \n"
            .   "\n" . $user1->name() . ': x'
            .   "\n" . $user2->name() . ': o'
        ;
        $game->userMoves($user1->id(), 1);
        $gameStatusResponse = GameStatusResponse::createFromGame($game);
        $this->assertEquals($expectedBoardString, $gameStatusResponse->boardString());

        $expectedBoardString =
            "x |   |  \n"
            .   "  | o |  \n"
            .   "  |   |  \n"
            .   "\n" . $user1->name() . ': x'
            .   "\n" . $user2->name() . ': o'
        ;
        $game->userMoves($user2->id(), 5);
        $gameStatusResponse = GameStatusResponse::createFromGame($game);
        $this->assertEquals($expectedBoardString, $gameStatusResponse->boardString());

    }
}