<?php


namespace TicTacToe\Application\Service\Game;


use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;

class GameStatusResponse
{
    private ?string $winnerId;
    private bool $isFinished;

    public static function createFromGame(Game $game): self
    {
        $self = new self();

        $self->winnerId = null;
        if ($game->winner() instanceof User) {
            $self->winnerId = $game->winner()->id();
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
}