<?php

require dirname(__DIR__) . '/src/Kernel.php';

use TicTacToe\Application\Service\User\CreateUserRequest;
use TicTacToe\Application\Service\User\CreateUserService;
use TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository;


try {
    $kernel = new Kernel();
    $userName = $argv[1] ? $argv[1] : '';

    $service = new CreateUserService(
        new FileUserRepository()
    );

    $user = $service->execute(new CreateUserRequest(
        $userName
    ));
    echo "\nUSER CREATED - ID: " . $user->id();

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";