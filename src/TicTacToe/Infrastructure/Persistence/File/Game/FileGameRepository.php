<?php


namespace TicTacToe\Infrastructure\Persistence\File\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\Game\GameNotFoundException;
use TicTacToe\Domain\Game\GameRepository;

class FileGameRepository implements GameRepository
{
    private string $fileName;
    private array $games = [];

    public function __construct($file = null)
    {
        if (!is_string($file) || empty($file)) {
            $file = 'FileGameRepository.file_db';
        } else {
            $file = $file . '.file_db';
        }

        $this->fileName = realpath(__DIR__) . '/../../../../../../var/file_repositories/' . $file;

        if (!file_exists($this->fileName)) {
            file_put_contents($this->fileName, null);
        } else {
            $content = file_get_contents($this->fileName);
            if ($content) {
                $this->games = unserialize($content);
            }
        }
    }
    public function add(Game $game): void
    {
        $this->games[$game->id()] = $game;
        $this->writeFile();
    }

    public function update(Game $game): void
    {
        $this->add($game);
    }

    /**
     * @param string $gameId
     * @return Game
     * @throws GameNotFoundException
     */
    public function byId(string $gameId): Game
    {
        if (isset($this->games[$gameId])) {
            return $this->games[$gameId];
        }

        throw new GameNotFoundException('GAME NOT FOUND: ' . $gameId);
    }

    private function writeFile(): void
    {
        file_put_contents($this->fileName, serialize($this->games));
    }

    public function emptyFile(): void
    {
        $this->games = [];
        $this->writeFile();
    }
}