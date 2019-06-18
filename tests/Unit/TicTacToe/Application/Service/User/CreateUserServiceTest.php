<?php

namespace Tests\Unit\TicTacToe\Application\Service\User;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\User\CreateUserRequest;
use TicTacToe\Application\Service\User\CreateUserService;
use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserRepository;

class CreateUserServiceTest extends TestCase
{
    public function testAValidUserIsCreated()
    {
        $service = new CreateUserService($this->createMock(UserRepository::class));

        $user = $service->execute(new CreateUserRequest('Username'));

        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserIsAddedToRepository()
    {
        $userRepo = $this->createMock(UserRepository::class);

        $userRepo
            ->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf(User::class));

        $service = new CreateUserService($userRepo);

        $service->execute(new CreateUserRequest('Username'));
    }
}