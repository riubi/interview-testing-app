<?php

namespace App\Testing\Domain;

class Answers
{
    /**
     * @var int[]
     */
    private array $answers;

    /**
     * @var int[] $questionMap
     */
    public function __construct(array $answers = [])
    {
        $this->answers = $answers;
    }

    public function compare(Answers $comparableAnswers): TestingResult
    {
        $sameAnswers = array_intersect($this->answers, $comparableAnswers->answers);
        $diffAnswers = array_merge(
            array_diff($this->answers, $comparableAnswers->answers),
            array_diff($comparableAnswers->answers, $this->answers));

        return new TestingResult($sameAnswers, $diffAnswers);
    }
}
