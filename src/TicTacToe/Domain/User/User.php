<?php

namespace TicTacToe\Domain\User;

use Ramsey\Uuid\Uuid;

class User
{
    private string $id;
    private string $name;

    private function __construct()
    {
    }

    public static function create(string $name): self
    {
        $self = new self();
        $self->assertName($name);
        $self->id = Uuid::uuid4()->toString();
        $self->name = $name;

        return $self;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    private function assertName(string $name): void
    {
        if (empty($name)) {
            throw new \Exception('NAME IS REQUIRED');
        }
    }
}