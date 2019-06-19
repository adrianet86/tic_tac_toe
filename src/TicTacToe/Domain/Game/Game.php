<?php


namespace TicTacToe\Domain\Game;


use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\User\User;

class Game
{
    const MINIM_USERS = 2;

    private string $id;
    private array $users;
    private int $totalUsers;
    private bool $isFinished;
    private ?User $winner;

    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->users = [];
        $this->totalUsers = 0;
        $this->isFinished = false;
        $this->winner = null;
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param User ...$users
     * @return Game
     * @throws GameRequiresMoreUsersException
     */
    public static function start(User ...$users): self
    {
        $self = new self();

        foreach ($users as $user) {
            $self->users[$user->id()] = $user;
            $self->totalUsers++;
        }

        $self->assertMinimUsers();

        return $self;
    }

    public function totalUsers(): int
    {
        return $this->totalUsers;
    }

    /**
     * @throws GameRequiresMoreUsersException
     */
    private function assertMinimUsers(): void
    {
        if ($this->totalUsers < self::MINIM_USERS) {
            throw new GameRequiresMoreUsersException("GAME REQUIRES " . self::MINIM_USERS);
        }

        return;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @param string $userId
     * @param Movement $movement
     * @return bool
     * @throws GameIsFinishedException
     */
    public function userMoves(string $userId, Movement $movement): bool
    {
        $this->assertIsNotFinished();
        $this->assertUserIsAUser($userId);

        if (rand(0, 5) % 2 == 0) {
            $this->setWinner($userId);
        }

        return true;
    }

    /**
     * @param string $userId
     */
    private function assertUserIsAUser(string $userId): void
    {
        if (isset($this->users[$userId])) {
            return;
        }

        throw new UserNotPlayingException('USER IS NOT PLAYING THIS GAME');
    }

    private function assertIsNotFinished(): void
    {
        if ($this->isFinished) {
            throw new GameIsFinishedException('GAME IS ENDED');
        }

        return;
    }

    public function winner(): ?User
    {
        return $this->winner;
    }

    private function setWinner(string $userId)
    {
        $this->winner = $this->users[$userId];
        $this->isFinished = true;
    }
}