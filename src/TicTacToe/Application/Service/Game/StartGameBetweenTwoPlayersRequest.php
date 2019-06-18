<?php


namespace TicTacToe\Application\Service\Game;


class StartGameBetweenTwoPlayersRequest
{
    private string $firstUserId;
    private string $secondUserId;

    public function __construct(string $firstUserId, string $secondUserId)
    {
        $this->firstUserId = $firstUserId;
        $this->secondUserId = $secondUserId;
    }

    public function firstUserId(): string
    {
        return $this->firstUserId;
    }

    public function secondUserId(): string
    {
        return $this->secondUserId;
    }
}