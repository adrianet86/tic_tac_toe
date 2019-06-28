<?php


namespace TicTacToe\Infrastructure\UI\Console\Command;


use TicTacToe\Application\Service\Game\GameStatusResponse;

class PrintGameBoard
{
    public static function print(GameStatusResponse $gameStatusResponse): string
    {
        $boardString = '';
        $tempBoard = [];
        $parseIdToSymbol = [
            $gameStatusResponse->firstUser()['id'] => 'x',
            $gameStatusResponse->secondUser()['id'] => 'o',
        ];
        foreach ($gameStatusResponse->board() as $field => $value) {
            if (!is_null($value)) {
                $tempBoard[$field] = $parseIdToSymbol[$value];
            } else {
                $tempBoard[$field] = ' ';
            }
        }

        $boardString .= $tempBoard[1] . ' | ' . $tempBoard[2] . ' | ' . $tempBoard[3] . "\n";
        $boardString .= $tempBoard[4] . ' | ' . $tempBoard[5] . ' | ' . $tempBoard[6] . "\n";
        $boardString .= $tempBoard[7] . ' | ' . $tempBoard[8] . ' | ' . $tempBoard[9] . "\n";

        $boardString .= "\n" . $gameStatusResponse->firstUser()['name'] . ': x';
        $boardString .= "\n" . $gameStatusResponse->secondUser()['name'] . ': o';

        return $boardString;
    }
}