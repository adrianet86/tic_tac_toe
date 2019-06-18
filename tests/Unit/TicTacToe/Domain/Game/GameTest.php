<?php


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameIsFinishedException;
use TicTacToe\Domain\Game\GameRequiresMoreUsersException;
use TicTacToe\Domain\Game\Movement;
use TicTacToe\Domain\Game\UserNotPlayingException;
use TicTacToe\Domain\User\User;

class GameTest extends \PHPUnit\Framework\TestCase
{
    public function testGameIsStartedBetweenTwoUsers()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals(2, $game->totalPlayers());
    }

    public function testWhenAGameIsStartedAValidUuidAsIdIsCreated()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $this->assertTrue(\Ramsey\Uuid\Uuid::isValid($game->id()));
    }

    public function testWhenAGameHasOnlyOneUserItThrowsAnException()
    {
        $user1 = User::create('user1');

        $this->expectException(GameRequiresMoreUsersException::class);

        Game::start($user1);
    }

    public function testPlayerMakesAMovement()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $this->assertTrue($game->playerMoves($user1, new Movement()));
    }

    public function testGameThrowsAnExceptionIfUserIsNotInPlaying()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $this->expectException(UserNotPlayingException::class);
        $game->playerMoves(User::create('user3'), new Movement());
    }

    public function testGameThrowsAnExceptionItIsFinished()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $game->end();

        $this->expectException(GameIsFinishedException::class);
        $game->playerMoves($user1, new Movement());
    }
}