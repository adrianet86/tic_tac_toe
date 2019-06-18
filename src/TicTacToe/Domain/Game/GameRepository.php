<?php


namespace TicTacToe\Domain\Game;


interface GameRepository
{
    public function add(Game $game): void;

    public function update(Game $game): void;

    /**
     * @param string $gameId
     * @return Game
     * @throws GameNotFoundException
     */
    public function byId(string $gameId): Game;
}