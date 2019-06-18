<?php


namespace Tests\Unit\TicTacToe\Infrastructure\Persistance\File\Game;


use PHPUnit\Framework\TestCase;

class FileGameRepositoryTest extends TestCase
{
    /**
     * @var FileUserRepository
     */
    private FileUserRepository $gameUserRepository;

    public function setUp(): void
    {
        $this->gameUserRepository = new Game('TestGameUserRepository');
    }

    public function tearDown(): void
    {
        $this->gameUserRepository->emptyFile();
    }
}