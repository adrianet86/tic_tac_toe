<?php


namespace Unit\TicTacToe\Infrastructure\Persistance\File\User;


use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserNotFoundException;
use TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository;

class FileUserRepositoryTest extends TestCase
{
    /**
     * @var FileUserRepository
     */
    private FileUserRepository $fileUserRepository;

    public function setUp(): void
    {
        $this->fileUserRepository = new FileUserRepository('TestFileUserRepository');
    }

    public function tearDown(): void
    {
        $this->fileUserRepository->emptyFile();
    }

    public function testWhenUserIsAddedItCanBeFoundByItsId()
    {
        $user = User::create('name');
        $this->fileUserRepository->add($user);

        $this->assertEquals($user, $this->fileUserRepository->byId($user->id()));
    }

    public function testWhenUserIsNotFoundAnExceptionIsThrown()
    {
        $this->expectException(UserNotFoundException::class);
        $this->fileUserRepository->byId('fake_id');
    }

    public function testWhenUserIsAddedItCanBeDeletedByItsId()
    {
        $user = User::create('name');
        $this->fileUserRepository->add($user);

        $this->assertNull($this->fileUserRepository->deleteById($user->id()));
    }

    public function testWhenUserIsNotFoundByDeletingAnExceptionIsThrown()
    {
        $this->expectException(UserNotFoundException::class);
        $this->fileUserRepository->deleteById('fake_id');
    }
}