<?php


namespace TicTacToe\Domain\Game;


use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\User\User;

class Game
{
    const MINIM_PLAYERS = 2;

    private string $id;
    private array $players;
    private int $totalPlayers;
    private bool $isFinished;

    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->players = [];
        $this->totalPlayers = 0;
        $this->isFinished = false;
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
            $self->players[$user->id()] = $user;
            $self->totalPlayers++;
        }

        $self->assertMinimPlayers();

        return $self;
    }

    public function totalPlayers(): int
    {
        return $this->totalPlayers;
    }

    /**
     * @throws GameRequiresMoreUsersException
     */
    private function assertMinimPlayers(): void
    {
        if ($this->totalPlayers < self::MINIM_PLAYERS) {
            throw new GameRequiresMoreUsersException("GAME REQUIRES " . self::MINIM_PLAYERS);
        }

        return;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @param User $player
     * @param Movement $movement
     * @return bool
     * @throws GameIsFinishedException
     */
    public function playerMoves(User $player, Movement $movement): bool
    {
        $this->assertIsNotFinished();
        $this->assertUserIsAPlayer($player);

        # TODO: something here I guess :p

        return true;
    }

    /**
     * @param User $user
     */
    private function assertUserIsAPlayer(User $user): void
    {
        if (isset($this->players[$user->id()])) {
            return;
        }

        throw new UserNotPlayingException('USER IS NOT PLAYING THIS GAME');
    }

    public function end(): void
    {
        $this->isFinished = true;
    }

    private function assertIsNotFinished(): void
    {
        if ($this->isFinished) {
            throw new GameIsFinishedException('GAME IS ENDED');
        }

        return;
    }

}