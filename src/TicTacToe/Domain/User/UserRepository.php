<?php


namespace TicTacToe\Domain\User;


interface UserRepository
{
    public function add(User $user);
}