<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameRepository;
use TicTacToe\Domain\User\UserRepository;

class StartGameBetweenTwoUsersService
{
    private UserRepository $userRepository;
    private GameRepository $gameRepository;

    public function __construct(UserRepository $userRepository, GameRepository $gameRepository)
    {
        $this->userRepository = $userRepository;
        $this->gameRepository = $gameRepository;
    }

    public function execute(StartGameBetweenTwoUsersRequest $request): Game
    {
        $firstUser = $this->userRepository->byId($request->firstUserId());
        $secondUser = $this->userRepository->byId($request->secondUserId());

        $game = Game::start($firstUser, $secondUser);

        $this->gameRepository->add($game);

        return $game;
    }
}