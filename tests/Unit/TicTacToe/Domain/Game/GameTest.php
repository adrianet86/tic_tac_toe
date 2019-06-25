<?php


use TicTacToe\Domain\Game\FieldFilledException;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameIsFinishedException;
use TicTacToe\Domain\Game\InvalidFieldException;
use TicTacToe\Domain\Game\UserNotPlayingException;
use TicTacToe\Domain\Game\UserTurnException;
use TicTacToe\Domain\User\User;

class GameTest extends \PHPUnit\Framework\TestCase
{
    public function testGameIsStartedBetweenTwoUsers()
    {
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testWhenAGameIsStartedAValidUuidAsIdIsCreated()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $this->assertTrue(\Ramsey\Uuid\Uuid::isValid($game->id()));
    }

    public function testUserMakesAMovement()
    {
        $user1 = User::create('user1');

        $game = Game::start($user1, User::create('user2'));

        $this->assertNull($game->userMoves($user1->id(), 1));
        $this->assertEquals($user1->id(), $game->board()[1]);
    }

    public function testGameThrowsAnExceptionIfUserIsNotPlaying()
    {
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->expectException(UserNotPlayingException::class);
        $game->userMoves('fake_id', 1);
    }

    public function testGameStartedHasNotAWinner()
    {
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->assertNull($game->winner());
    }

    public function testWhenIsNotUserTurnItWillThrowAnException()
    {
        $user1 = User::create('user1');

        $game = Game::start($user1, User::create('user2'));

        $game->userMoves($user1->id(), 1);

        $this->expectException(UserTurnException::class);
        $game->userMoves($user1->id(), 2);
    }

    public function testWhenTriesToMoveToAFilledFieldItWillThrowAnException()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $game->userMoves($user1->id(), 1);

        $this->expectException(FieldFilledException::class);
        $game->userMoves($user2->id(), 1);
    }

    public function testGameIsPlayedAndHasAWinner()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $game->userMoves($user1->id(), 1);
        $game->userMoves($user2->id(), 3);
        $game->userMoves($user1->id(), 5);
        $game->userMoves($user2->id(), 6);
        $game->userMoves($user1->id(), 9);

        # TODO: should check all winner possibilities¿?


        $this->assertNotNull($game->winner());
        $this->assertEquals($user1, $game->winner());
        $this->assertInstanceOf(User::class, $game->winner());
        $this->assertTrue($game->isFinished());
    }

    public function testGameThrowsAnExceptionIfIsFinishedByAWinner()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $game->userMoves($user1->id(), 1);
        $game->userMoves($user2->id(), 5);
        $game->userMoves($user1->id(), 2);
        $game->userMoves($user2->id(), 6);
        $game->userMoves($user1->id(), 3);

        $this->expectException(GameIsFinishedException::class);

        $game->userMoves($user2->id(), 6);
    }

    public function testGameIsFinishedByDraw()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $game->userMoves($user2->id(), 9);
        $game->userMoves($user1->id(), 1);
        $game->userMoves($user2->id(), 2);
        $game->userMoves($user1->id(), 3);
        $game->userMoves($user2->id(), 4);
        $game->userMoves($user1->id(), 5);
        $game->userMoves($user2->id(), 6);
        $game->userMoves($user1->id(), 8);
        $game->userMoves($user2->id(), 7);


        $this->assertTrue($game->isFinished());
        $this->assertNull($game->winner());
    }

    public function testWhenInvalidBoardFieldIsPlayedAnExceptionIsThrown()
    {
        $user1 = User::create('user1');

        $game = Game::start($user1, User::create('user2'));
        $this->expectException(InvalidFieldException::class);
        $game->userMoves($user1->id(), 10);
    }
}