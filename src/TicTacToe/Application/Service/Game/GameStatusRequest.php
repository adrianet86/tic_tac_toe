<?php


namespace TicTacToe\Application\Service\Game;


class GameStatusRequest
{
    private string $gameId;

    public function __construct(string $gameId)
    {
        $this->gameId = $gameId;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }
}