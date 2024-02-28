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

    public function evaluate(Answers $answers, ExpressionComparator $comparator, ResultRepository $resultRepository): TestingResult
    {
        $result = $this
            ->getCorrectAnswers($comparator)
            ->compare($answers);

        $resultRepository->save($result);

        return $result;
    }

    private function getCorrectAnswers(ExpressionComparator $comparator): Answers
    {
        $correctAnswers = [];
        foreach ($this->questions as $question) {
            $questionExpression = $question->getExpression();
            foreach ($question->getOptions() as $option) {
                if ($comparator->isEqual($questionExpression, $option->getExpression())) {
                    $correctAnswers[] = $option->getOptionId();
                }
            }
        }

        return new Answers($correctAnswers);
    }

    public function randomize(): void
    {
        foreach($this->questions as $question) {
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
