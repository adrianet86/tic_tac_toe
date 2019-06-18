<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\UserRepository;

class StartGameBetweenTwoPlayersService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(StartGameBetweenTwoPlayersRequest $request): Game
    {
        $firstPlayer = $this->userRepository->byId($request->firstUserId());
        $secondPlayer = $this->userRepository->byId($request->secondUserId());

        $game = Game::start($firstPlayer, $secondPlayer);

        return $game;
    }
}