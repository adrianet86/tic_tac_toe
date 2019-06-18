<?php

namespace TicTacToe\Application\Service\User;

use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserRepository;

class CreateUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserRequest $request): User
    {
        $user = User::create($request->name());

        $this->userRepository->add($user);

        return $user;
    }
}