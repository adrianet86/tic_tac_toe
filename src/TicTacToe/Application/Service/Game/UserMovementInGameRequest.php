<?php


namespace TicTacToe\Application\Service\Game;


class UserMovementInGameRequest
{
    private string $userId;
    private string $gameId;
    private int $movement;

    public function __construct(string $userId, string $gameId, int $movement)
    {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->movement = $movement;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }

    public function movement(): int
    {
        return $this->movement;
    }
}