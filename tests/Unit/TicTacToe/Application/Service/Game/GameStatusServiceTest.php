<?php


namespace Tests\Unit\TicTacToe\Application\Service\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusRequest;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Application\Service\Game\GameStatusService;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameRepository;
use TicTacToe\Domain\User\User;

class GameStatusServiceTest extends TestCase
{
    public function testGameStatusServiceReturnsAGameStatusResponse()
    {
        $game = Game::start(
            User::create('user1'),
            User::create('user2')
        );

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->method('byId')
            ->willReturn($game);

        $service = new GameStatusService(
            $gameRepository
        );

        $gameStatusResponse = $service->execute(new GameStatusRequest($game->id()));

        $this->assertInstanceOf(GameStatusResponse::class, $gameStatusResponse);
    }
}