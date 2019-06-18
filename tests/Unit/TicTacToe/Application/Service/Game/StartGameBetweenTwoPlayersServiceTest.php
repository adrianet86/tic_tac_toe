<?php


namespace Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\StartGameBetweenTwoPlayersRequest;
use TicTacToe\Application\Service\Game\StartGameBetweenTwoPlayersService;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserRepository;

class StartGameBetweenTwoPlayersServiceTest extends TestCase
{
    public function testAGameIsStartedBetweenTwoPlayersByUserId()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');

        $request = new StartGameBetweenTwoPlayersRequest(
            $user1->id(),
            $user2->id()
        );

        $userRepo = $this->createMock(UserRepository::class);

        $userRepo->method('byId')->willReturnOnConsecutiveCalls(
            $user1,
            $user2
        );

        $service = new StartGameBetweenTwoPlayersService($userRepo);

        $game = $service->execute($request);

        $this->assertInstanceOf(Game::class, $game);
        $this->assertFalse($game->isFinished());
    }
}