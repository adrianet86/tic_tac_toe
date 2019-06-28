<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;

class GameStatusResponse
{
    private string $gameId;
    private bool $isFinished;
    private array $board;
    private array $firstUser;
    private array $secondUser;
    private array $winner;

    public static function createFromGame(Game $game): self
    {
        $self = new self();
        $self->gameId = $game->id();
        $self->winner = [];
        $self->board = $game->board();
        $self->firstUser = [
            'id' => $game->firstUser()->id(),
            'name' => $game->firstUser()->name()
        ];
        $self->secondUser = [
            'id' => $game->secondUser()->id(),
            'name' => $game->secondUser()->name()
        ];

        if ($game->winner() instanceof User) {
            $self->winner = [
                'id' => $game->winner()->id(),
                'name' => $game->winner()->name()
            ];
        }

        $self->isFinished = $game->isFinished();

        return $self;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }

    public function board(): array
    {
        return $this->board;
    }

    public function winner(): array
    {
        return $this->winner;
    }

    public function firstUser(): array
    {
        return $this->firstUser;
    }

    public function secondUser(): array
    {
        return $this->secondUser;
    }

}