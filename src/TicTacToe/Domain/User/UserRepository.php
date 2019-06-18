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

    /**
     * @param string $firstUserId
     * @return User
     * @throws UserNotFoundException
     */
    public function byId(string $firstUserId): User;
}