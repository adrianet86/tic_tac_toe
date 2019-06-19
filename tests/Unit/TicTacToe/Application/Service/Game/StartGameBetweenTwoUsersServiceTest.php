<?php


namespace Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Application\Service\Game\StartGameBetweenTwoUsersRequest;
use TicTacToe\Application\Service\Game\StartGameBetweenTwoUsersService;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameRepository;
use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserRepository;

class StartGameBetweenTwoUsersServiceTest extends TestCase
{
    public function testAGameIsStartedBetweenTwoUsersByUserId()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $request = new StartGameBetweenTwoUsersRequest(
            $user1->id(),
            $user2->id()
        );

        $userRepo = $this->createMock(UserRepository::class);

        $userRepo->method('byId')->willReturnOnConsecutiveCalls(
            $user1,
            $user2
        );

        $service = new StartGameBetweenTwoUsersService(
            $userRepo,
            $this->createMock(GameRepository::class)
        );

        $gameStatusResponse = $service->execute($request);

        $this->assertInstanceOf(GameStatusResponse::class, $gameStatusResponse);
        $this->assertFalse($gameStatusResponse->isFinished());
    }

    public function testWhenAGameIsStartedItIsPersisted()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $request = new StartGameBetweenTwoUsersRequest(
            $user1->id(),
            $user2->id()
        );

        $userRepo = $this->createMock(UserRepository::class);
        $gameRepo = $this->createMock(GameRepository::class);

        $gameRepo
            ->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf(Game::class));

        $userRepo->method('byId')->willReturnOnConsecutiveCalls(
            $user1,
            $user2
        );

        $service = new StartGameBetweenTwoUsersService($userRepo, $gameRepo);

        $service->execute($request);
    }
}