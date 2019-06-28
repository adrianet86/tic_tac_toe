<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\Game\GameStatusRequest;
use TicTacToe\Application\Service\Game\GameStatusService;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;
use TicTacToe\Infrastructure\UI\Console\Command\PrintGameBoard;


try {
    $kernel = new Kernel();
    $gameId = $argv[1] ? $argv[1] : '';

    $service = new GameStatusService(
        new FileGameRepository()
    );

    $gameStatusResponse = $service->execute(new GameStatusRequest($gameId));

    echo "\n" . PrintGameBoard::print($gameStatusResponse);

    echo "\nGame " . ($gameStatusResponse->isFinished() ? 'finished' : 'playing');
    if ($gameStatusResponse->isFinished()) {
        if (!empty($gameStatusResponse->winner())) {
            echo "\nWinner is " . $gameStatusResponse->winner()['name']
                . ' - '
                . $gameStatusResponse->winner()['id'];
        } else {
            echo "\nDraw";
        }
    }

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";