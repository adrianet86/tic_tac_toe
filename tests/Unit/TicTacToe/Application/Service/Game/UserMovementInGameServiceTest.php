<?php


namespace Tests\Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Application\Service\Game\UserMovementInGameRequest;
use TicTacToe\Application\Service\Game\UserMovementInGameService;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameRepository;
use TicTacToe\Domain\User\User;

class UserMovementInGameServiceTest extends TestCase
{
    public function testWhenAUserMovesItIsPersisted()
    {
        $user = User::create('user1');
        $game = Game::start($user, User::create('user2'));
        $movement = 'left';

        $request = new UserMovementInGameRequest(
            $user->id(),
            $game->id(),
            $movement
        );

        $gameRepo = $this->createMock(GameRepository::class);
        $gameRepo->method('byId')
            ->willReturn($game);

        $gameRepo->expects($this->once())
            ->method('update')
            ->with($game);

        $service = new UserMovementInGameService(
            $gameRepo
        );

        $service->execute($request);
    }

    public function testWhenAUserMovesAGameStatusResponseIsReturned()
    {
        $user = User::create('user1');
        $game = Game::start($user, User::create('user2'));
        $movement = 'left';

        $request = new UserMovementInGameRequest(
            $user->id(),
            $game->id(),
            $movement
        );

        $gameRepo = $this->createMock(GameRepository::class);
        $gameRepo->method('byId')
            ->willReturn($game);

        $service = new UserMovementInGameService($gameRepo);

        $gameStatusResponse = $service->execute($request);

        $this->assertInstanceOf(GameStatusResponse::class, $gameStatusResponse);
    }
}