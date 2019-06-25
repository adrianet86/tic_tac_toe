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
    private array $board;
    private string $boardString;

    public static function createFromGame(Game $game): self
    {
        $self = new self();
        $self->gameId = $game->id();
        $self->winnerId = null;
        $self->winnerName = null;
        $self->board = $game->board();
        $self->setBoardToString($game);

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

    private function setBoardToString(Game $game): void
    {
        $this->boardString = '';
        $tempBoard = [];
        $parseIdToSymbol = [
            $game->firstUser()->id() => 'x',
            $game->secondUser()->id() => 'o',
        ];
        foreach ($game->board() as $field => $value) {
            if (!is_null($value)) {
                $tempBoard[$field] = $parseIdToSymbol[$value];
            } else {
                $tempBoard[$field] = ' ';
            }

        }

        $this->boardString .= $tempBoard[1] . ' | ' . $tempBoard[2] . ' | ' . $tempBoard[3] . "\n";
        $this->boardString .= $tempBoard[4] . ' | ' . $tempBoard[5] . ' | ' . $tempBoard[6] . "\n";
        $this->boardString .= $tempBoard[7] . ' | ' . $tempBoard[8] . ' | ' . $tempBoard[9] . "\n";

        $this->boardString .= "\n" . $game->firstUser()->name() . ': x';
        $this->boardString .= "\n" . $game->secondUser()->name() . ': o';
    }

    public function board(): array
    {
        return $this->board;
    }

    public function boardString(): string
    {
        return $this->boardString;
    }

}