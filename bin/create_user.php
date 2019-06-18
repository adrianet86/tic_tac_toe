<?php

require dirname(__DIR__) . '/src/Kernel.php';


try {
    $kernel = new Kernel();
    $userName = $argv[1];

    $service = new \TicTacToe\Application\Service\User\CreateUserService(
        new \TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository()
    );

    $user = $service->execute(new \TicTacToe\Application\Service\User\CreateUserRequest(
        $userName
    ));
    echo "\nUSER CREATED - ID: " . $user->id();

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";