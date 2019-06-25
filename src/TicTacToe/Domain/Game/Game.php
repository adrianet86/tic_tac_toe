<?php


namespace TicTacToe\Domain\Game;


use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\User\User;

class Game
{
    const MAX_FIELDS = 9;
    const HORIZONTAL_1 = [1, 2, 3];
    const HORIZONTAL_2 = [4, 5, 6];
    const HORIZONTAL_3 = [7, 8, 9];
    const VERTICAL_1 = [1, 4, 7];
    const VERTICAL_2 = [2, 5, 8];
    const VERTICAL_3 = [3, 6, 9];
    const DIAGONAL_1 = [5, 1, 9];
    const DIAGONAL_2 = [5, 3, 7];

    const WINNER_LINES = [
        self::HORIZONTAL_1,
        self::HORIZONTAL_2,
        self::HORIZONTAL_3,
        self::VERTICAL_1,
        self::VERTICAL_2,
        self::VERTICAL_3,
        self::DIAGONAL_1,
        self::DIAGONAL_2
    ];

    private string $id;
    private array $board;
    private int $fieldsFilled;
    private bool $isFinished;
    private ?string $winnerId;
    private User $firstUser;
    private User $secondUser;
    private ?string $lastMovementUserId;


    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->isFinished = false;
        $this->winnerId = null;
        $this->lastMovementUserId = null;
        $this->fieldsFilled = 0;
        for ($i = 1; $i < 10; $i++) {
            $this->board[$i] = null;
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param User $firstUser
     * @param User $secondUser
     * @return Game
     */
    public static function start(User $firstUser, User $secondUser): self
    {
        $self = new self();
        $self->firstUser = $firstUser;
        $self->secondUser = $secondUser;

        return $self;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @param string $userId
     * @param int $field
     * @return void
     * @throws FieldFilledException
     * @throws GameIsFinishedException
     * @throws UserNotPlayingException
     * @throws UserTurnException
     * @throws InvalidFieldException
     */
    public function userMoves(string $userId, int $field): void
    {
        $this->assertIsNotFinished();
        $this->assertValidField($field);
        $this->assertUserIsPlaying($userId);
        $this->assertUserTurn($userId);
        $this->assertFieldIsNotFilled($field);

        $this->board[$field] = $userId;
        $this->lastMovementUserId = $userId;
        $this->fieldsFilled++;
        if ($this->fieldsFilled >= self::MAX_FIELDS) {
            $this->isFinished = true;
        }

        if ($this->gameCanHaveWinner()) {
            foreach (self::WINNER_LINES as $line) {
                $this->winnerId = $this->getWinnerByLine($line);
                if (!is_null($this->winnerId)) {
                    $this->isFinished = true;
                    return;
                }
            }
        }

        return;
    }

    private function getWinnerByLine(array $line): ?string
    {
        if (!is_null($this->board[$line[0]])
            && $this->board[$line[0]] == $this->board[$line[1]]
            && $this->board[$line[1]] == $this->board[$line[2]]) {

            return $this->board[$line[0]];
        }

        return null;
    }

    /**
     * @param string $userId
     * @throws UserNotPlayingException
     */
    private function assertUserIsPlaying(string $userId): void
    {
        if ($this->firstUser->id() == $userId || $this->secondUser->id() == $userId) {
            return;
        }

        throw new UserNotPlayingException('USER IS NOT PLAYING THIS GAME');
    }

    private function assertIsNotFinished(): void
    {
        if ($this->isFinished) {
            throw new GameIsFinishedException('GAME IS ENDED');
        }

        return;
    }

    public function winner(): ?User
    {
        if ($this->winnerId == $this->firstUser->id()) {
            return $this->firstUser;
        }

        if ($this->winnerId == $this->secondUser->id()) {
            return $this->secondUser;
        }

        return null;
    }

    private function assertUserTurn(string $userId)
    {
        if ($this->lastMovementUserId == $userId) {
            throw new UserTurnException('IS NOT YOUR TURN');
        }
    }

    /**
     * @param int $field
     * @throws FieldFilledException
     */
    private function assertFieldIsNotFilled(int $field): void
    {
        if (!is_null($this->board[$field])) {
            throw new FieldFilledException('FIELD ALREADY FILLED: ' . $field);
        }

        return;
    }

    /**
     * @return bool
     */
    private function gameCanHaveWinner(): bool
    {
        return $this->fieldsFilled >= 5;
    }

    private function assertValidField(int $field)
    {
        if ($field < 1 || $field > self::MAX_FIELDS) {
            throw new InvalidFieldException('INVALID BOARD FIELD, ONLY FROM 1 TO 9 : ' . $field);
        }
    }

    public function board(): array
    {
        return $this->board;
    }

    public function firstUser(): User
    {
        return $this->firstUser;
    }

    public function secondUser(): User
    {
        return $this->secondUser;
    }

}