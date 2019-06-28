<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\Game\UserMovementInGameRequest;
use TicTacToe\Application\Service\Game\UserMovementInGameService;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;
use TicTacToe\Infrastructure\UI\Console\Command\PrintGameBoard;


try {
    $kernel = new Kernel();
    $userId = $argv[1] ? $argv[1] : '';
    $gameId = $argv[2] ? $argv[2] : '';
    $movement = $argv[3] ? $argv[3] : 0;

    $service = new UserMovementInGameService(
        new FileGameRepository()
    );

    $gameStatusResponse = $service->execute(new UserMovementInGameRequest(
        $userId,
        $gameId,
        $movement
    ));

    echo "\nMovement done!";
    echo "\n" . PrintGameBoard::print($gameStatusResponse);

    if ($gameStatusResponse->isFinished()) {
        echo "\nGame finished!";
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