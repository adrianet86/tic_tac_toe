<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\GameRepository;
use TicTacToe\Domain\Game\Movement;

class UserMovementInGameService
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function execute(UserMovementInGameRequest $request)
    {
        $game = $this->gameRepository->byId($request->gameId());

        $game->userMoves($request->userId(), new Movement($request->movement()));

        $this->gameRepository->update($game);
    }
}