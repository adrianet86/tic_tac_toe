<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\Game\UserMovementInGameRequest;
use TicTacToe\Application\Service\Game\UserMovementInGameService;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;


try {
    $kernel = new Kernel();
    $userId = $argv[1] ? $argv[1] : '';
    $gameId = $argv[2] ? $argv[2] : '';
    $movement = $argv[3] ? $argv[3] : '';

    $service = new UserMovementInGameService(
        new FileGameRepository()
    );

    $service->execute(new UserMovementInGameRequest(
        $userId,
        $gameId,
        $movement
    ));

    echo "\nMOVEMENT DONE!";

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";