<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\User\DeleteUserRequest;
use TicTacToe\Application\Service\User\DeleteUserService;
use TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository;


try {
    $kernel = new Kernel();
    $userId = $argv[1] ? $argv[1] : '';

    $service = new DeleteUserService(
        new FileUserRepository()
    );

    $service->execute(new DeleteUserRequest(
        $userId
    ));
    echo "\nUSER DELETED";

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";