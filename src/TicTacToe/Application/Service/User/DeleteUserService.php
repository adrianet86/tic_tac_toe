<?php


namespace TicTacToe\Application\Service\User;


use TicTacToe\Domain\User\UserRepository;

class DeleteUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserRequest $request
     * @throws \TicTacToe\Domain\User\UserNotFoundException
     */
    public function execute(DeleteUserRequest $request)
    {
        $this->userRepository->deleteById($request->userId());
    }
}