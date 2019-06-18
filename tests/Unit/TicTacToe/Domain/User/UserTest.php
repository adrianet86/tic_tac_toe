<?php

namespace Tests\Unit\TicTacToe\Domain\User;


use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\User\User;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testUserIsCreatedWithCorrectUuidAsId()
    {
        $user = User::create('name');

        $this->assertTrue(Uuid::isValid($user->id()));
    }

    public function testWhenUserIsCreatedWithEmptyNameAnExceptionIsThrown()
    {
        $this->expectException(\Exception::class);

        User::create('');
    }
}