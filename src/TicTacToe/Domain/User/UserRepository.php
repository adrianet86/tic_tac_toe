<?php


namespace TicTacToe\Domain\User;


interface UserRepository
{
    public function add(User $user);

    /**
     * @param string $userId
     * @throws UserNotFoundException
     */
    public function deleteById(string $userId);
}