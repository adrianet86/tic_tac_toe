<?php


namespace Tests\Unit\TicTacToe\Application\Service\User;


use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TicTacToe\Application\Service\User\DeleteUserRequest;
use TicTacToe\Application\Service\User\DeleteUserService;
use TicTacToe\Domain\User\UserRepository;

class DeleteUserServiceTest extends TestCase
{
    public function testUserIsDeletedFromRepository()
    {
        $userId = Uuid::uuid4()->toString();

        $request = new DeleteUserRequest($userId);

        $userRepo = $this->createMock(UserRepository::class);

        $userRepo
            ->expects($this->once())
            ->method('deleteById')
            ->with($userId);

        $service = new DeleteUserService($userRepo);

        $service->execute($request);
    }
}