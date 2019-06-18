<?php


namespace TicTacToe\Infrastructure\Persistence\File\User;


use TicTacToe\Domain\User\User;
use TicTacToe\Domain\User\UserNotFoundException;
use TicTacToe\Domain\User\UserRepository;

class FileUserRepository implements UserRepository
{
    private string $fileName;
    private array $users = [];

    public function __construct($file = null)
    {
        if (!is_string($file) || empty($file)) {
            $file = 'FileUserRepository.file_db';
        } else {
            $file = $file . '.file_db';
        }

        $this->fileName = realpath(__DIR__) . '/../../../../../../var/file_repositories/' . $file;

        if (!file_exists($this->fileName)) {
            file_put_contents($this->fileName, null);
        } else {
            $content = file_get_contents($this->fileName);
            if ($content) {
                $this->users = unserialize($content);
            }
        }
    }

    public function add(User $user)
    {
        $this->users[$user->id()] = $user;
        $this->writeFile();
    }

    /**
     * @param string $userId
     * @throws UserNotFoundException
     */
    public function deleteById(string $userId): void
    {
        $userId = trim($userId);
        if (isset($this->users[$userId])) {
            unset($this->users[$userId]);
            $this->writeFile();
            return;
        }

        throw new UserNotFoundException('USER NOT FOUND');
    }

    /**
     * @param string $userId
     * @return User
     * @throws UserNotFoundException
     */
    public function byId(string $userId): User
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }

        throw new UserNotFoundException('USER NOT FOUND');
    }

    private function writeFile(): void
    {
        file_put_contents($this->fileName, serialize($this->users));
    }

    public function emptyFile(): void
    {
        $this->users = [];
        $this->writeFile();
    }
}