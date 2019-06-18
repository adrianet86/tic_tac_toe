<?php


namespace Tests\Unit\TicTacToe\Infrastructure\Persistance\File\Game;


use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameNotFoundException;
use TicTacToe\Domain\User\User;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;

class FileGameRepositoryTest extends TestCase
{
    /**
     * @var FileGameRepository
     */
    private FileGameRepository $gameRepository;

    public function setUp(): void
    {
        $this->gameRepository = new FileGameRepository('TestGameUserRepository');
    }

    public function tearDown(): void
    {
        $this->gameRepository->emptyFile();
    }

    public function testWhenGameIsAddedItCanBeFoundByItsId()
    {
        $game = Game::start(
            User::create('name'),
            User::create('name')
        );
        $this->gameRepository->add($game);

        $this->assertEquals($game, $this->gameRepository->byId($game->id()));
    }

    public function testWhenGameIsNotFoundAnExceptionIsThrown()
    {
        $this->expectException(GameNotFoundException::class);
        $this->gameRepository->byId('fake_id');
    }
}