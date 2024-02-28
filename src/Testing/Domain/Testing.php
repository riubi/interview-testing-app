<?php

namespace App\Testing\Domain;

use App\Evaluator\Contract\ExpressionComparator;
use JsonSerializable;

class Testing implements JsonSerializable
{
    /**
     * @var Question[]
     */
    private array $questions;

    /**
     * @param Question[] $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    public function evaluate(array $selectedOptions, ExpressionComparator $comparator, ResultRepository $resultRepository): TestingResult
    {
        $result = AnswersEvaluator::createByQuestionsEval($this->questions, $comparator)
            ->compare($selectedOptions);

        $resultRepository->save($result);

        return $result;
    }

    public function randomize(): void
    {
        foreach ($this->questions as $question) {
            $question->randomize();
        }

        shuffle($this->questions);
    }

    public function jsonSerialize(): array
    {
        return [
            'questions' => array_map(function ($question) {
                return $question->jsonSerialize();
            }, $this->questions),
        ];
    }
}
