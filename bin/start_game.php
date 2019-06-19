<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\Game\StartGameBetweenTwoUsersRequest;
use TicTacToe\Application\Service\Game\StartGameBetweenTwoUsersService;
use TicTacToe\Infrastructure\Persistence\File\Game\FileGameRepository;
use TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository;


try {
    $kernel = new Kernel();
    $firstUserId = $argv[1] ? $argv[1] : '';
    $secondUserId = $argv[2] ? $argv[2] : '';

    $service = new StartGameBetweenTwoUsersService(
        new FileUserRepository(),
        new FileGameRepository()
    );

    $game = $service->execute(new StartGameBetweenTwoUsersRequest(
        $firstUserId,
        $secondUserId
    ));

    echo "\nGAME STARTED - ID: " . $game->id();

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";