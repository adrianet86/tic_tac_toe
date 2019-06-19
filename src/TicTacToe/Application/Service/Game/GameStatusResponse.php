<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;

class GameStatusResponse
{
    private string $gameId;
    private ?string $winnerId;
    private ?string $winnerName;
    private bool $isFinished;

    public static function createFromGame(Game $game): self
    {
        $self = new self();
        $self->gameId = $game->id();
        $self->winnerId = null;
        $self->winnerName = null;
        if ($game->winner() instanceof User) {
            $self->winnerId = $game->winner()->id();
            $self->winnerName = $game->winner()->name();
        }

        $self->isFinished = $game->isFinished();

        return $self;
    }

    public function winnerId(): ?string
    {
        return $this->winnerId;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function winnerName(): ?string
    {
        return $this->winnerName;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }
}