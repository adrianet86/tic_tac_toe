<?php


namespace Tests\Unit\TicTacToe\Infrastructure\Console\Command;


use PHPUnit\Framework\TestCase;
use TicTacToe\Application\Service\Game\GameStatusResponse;
use TicTacToe\Domain\Game\Game;
use TicTacToe\Domain\User\User;
use TicTacToe\Infrastructure\UI\Console\Command\PrintGameBoard;

class PrintGameBoardTest extends TestCase
{
    public function testTransformBoardFromGameStatusResponseToPrintableString()
    {
        $user1 = User::create('user1');
        $user2 = User::create('user2');
        $game = Game::start($user1, $user2);

        $gameStatusResponse = GameStatusResponse::createFromGame($game);

        $gameBoardPrintedString = PrintGameBoard::print($gameStatusResponse);
        $expectedBoardString =
            "  |   |  \n"
            .   "  |   |  \n"
            .   "  |   |  \n"
            .   "\n" . $user1->name() . ': x'
            .   "\n" . $user2->name() . ': o'
        ;

        $this->assertEquals($expectedBoardString, $gameBoardPrintedString);
    }
}