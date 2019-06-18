<?php

require dirname(__DIR__) . '/src/Kernel.php';


try {
    $kernel = new Kernel();
    $userId = $argv[1];

    $service = new \TicTacToe\Application\Service\User\DeleteUserService(
        new \TicTacToe\Infrastructure\Persistence\File\User\FileUserRepository()
    );

    $service->execute(new \TicTacToe\Application\Service\User\DeleteUserRequest(
        $userId
    ));
    echo "\nUSER DELETED";

} catch (Exception $exception) {
    echo "\nERROR: " . $exception->getMessage();
}

echo "\n";