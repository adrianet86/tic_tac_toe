<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\GameRepository;

class UserMovementInGameService
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function execute(UserMovementInGameRequest $request): GameStatusResponse
    {
        $game = $this->gameRepository->byId($request->gameId());

        $game->userMoves($request->userId(), $request->movement());

        $this->gameRepository->update($game);

        return GameStatusResponse::createFromGame($game);
    }
}