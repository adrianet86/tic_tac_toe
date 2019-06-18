<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\GameRepository;

class GameStatusService
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function execute(GameStatusRequest $request): GameStatusResponse
    {
        return GameStatusResponse::createFromGame(
            $this->gameRepository->byId($request->gameId())
        );
    }


}