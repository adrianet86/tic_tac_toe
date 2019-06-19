<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\Game\GameStatusRequest;
use TicTacToe\Application\Service\Game\GameStatusService;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;


try {
    $kernel = new Kernel();
    $gameId = $argv[1] ? $argv[1] : '';

    $service = new GameStatusService(
        new FileGameRepository()
    );

    $gameStatusResponse = $service->execute(new GameStatusRequest($gameId));

    echo "\nGAME is " . ($gameStatusResponse->isFinished() ? 'finished' : 'playing');
    if ($gameStatusResponse->isFinished()) {
        echo "\n Winner id is " . $gameStatusResponse->winnerId();
    }

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";