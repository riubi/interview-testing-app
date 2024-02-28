<?php

namespace App\Testing\Domain;

use JsonSerializable;

class TestingResult implements JsonSerializable
{
    private array $correctAnswers;
    private array $wrongAnswers;

    /**
     * @param int[] $correctAnswers
     * @param int[] $wrongAnswers
     */
    public function __construct(array $correctAnswers, array $wrongAnswers)
    {
        $this->correctAnswers = $correctAnswers;
        $this->wrongAnswers = $wrongAnswers;
    }

    public function getCorrectAnswers(): int
    {
        return count($this->correctAnswers);
    }

    public function getWrongAnswers(): int
    {
        return count($this->wrongAnswers);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'correctAnswers' => $this->correctAnswers,
            'wrongAnswers' => $this->wrongAnswers,
        ];
    }
}
