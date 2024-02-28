<?php

namespace App\Testing\Domain;

use JsonSerializable;

class TestingStats implements JsonSerializable
{
    private int $submittedResults;
    private int $correctAnswers;
    private int $wrongAnswers;

    public function __construct(int $submittedResults, int $correctAnswers, int $wrongAnswers)
    {
        $this->submittedResults = $submittedResults;
        $this->correctAnswers = $correctAnswers;
        $this->wrongAnswers = $wrongAnswers;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'submittedResults' => $this->submittedResults,
            'correctAnswers' => $this->correctAnswers,
            'wrongAnswers' => $this->wrongAnswers,
        ];
    }
}
