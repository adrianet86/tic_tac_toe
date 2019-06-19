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
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals(2, $game->totalUsers());
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

    public function testUserMakesAMovement()
    {
        $user1 = User::create('user1');

        $game = Game::start($user1, User::create('user2'));

        $this->assertTrue($game->userMoves($user1->id(), new Movement('right')));
    }

    public function testGameThrowsAnExceptionIfUserIsNotInPlaying()
    {
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->expectException(UserNotPlayingException::class);
        $game->userMoves('fake_id', new Movement('right'));
    }

    public function testGameStartedHasNotAWinner()
    {
        $game = Game::start(User::create('user1'), User::create('user2'));

        $this->assertNull($game->winner());
    }

    public function testGameIsPlayedUntilUserWinsRandomly()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        while (!$game->isFinished()) {
            $game->userMoves($user1->id(), new Movement('right'));
        }

        $this->assertNotNull($game->winner());
        $this->assertInstanceOf(User::class, $game->winner());
        $this->assertTrue($game->isFinished());
    }

    public function testGameThrowsAnExceptionIfIsFinished()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $game = Game::start($user1, $user2);

        $count = 1;
        $this->expectException(GameIsFinishedException::class);
        while (true) {
            if ($count % 2 != 0) {
                $game->userMoves($user1->id(), new Movement('right'));
            } else {
                $game->userMoves($user2->id(), new Movement('right'));
            }
            $count++;
        }
    }
}