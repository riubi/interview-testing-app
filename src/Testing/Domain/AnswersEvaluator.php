<?php

namespace App\Testing\Domain;

use App\Evaluator\Contract\ExpressionComparator;

class AnswersEvaluator implements Answers
{
    /**
     * @var Question[]
     */
    private array $questions;
    private ExpressionComparator $comparator;

    /**
     * @param Question[] $questions
     * @param ExpressionComparator $comparator
     */
    public function __construct(array $questions, ExpressionComparator $comparator)
    {
        $this->questions = $questions;
        $this->comparator = $comparator;
    }

    public function compare(array $selectedOptions): TestingResult
    {
        $selectedKeyMap = array_flip($selectedOptions);
        $correctOptions = [];
        $wrongOptions = [];

        foreach ($this->questions as $question) {
            $isCorrectAnswer = false;
            foreach ($question->getOptions() as $option) {
                if (array_key_exists($option->getOptionId(), $selectedKeyMap)) {
                    if ($this->comparator->isEqual($question->getExpression(), $option->getExpression())) {
                        $isCorrectAnswer = true;
                    } else {
                        $isCorrectAnswer = false;
                        break;
                    }
                }
            }

            if ($isCorrectAnswer) {
                $correctOptions[] = $question->getQuestionId();
            } else {
                $wrongOptions[] = $question->getQuestionId();
            }
        }

        return new TestingResult($correctOptions, $wrongOptions);
    }

    public static function createByQuestionsEval(array $questions, ExpressionComparator $comparator): self
    {
        return new AnswersEvaluator($questions, $comparator);
    }
}
