<?php


namespace TicTacToe\Domain\User;


interface UserRepository
{
    public function add(User $user);

    /**
     * @param string $userId
     * @throws UserNotFoundException
     */
    public function deleteById(string $userId): void;

    /**
     * @param string $userId
     * @return User
     * @throws UserNotFoundException
     */
    public function byId(string $userId): User;
}