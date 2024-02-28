<?php

namespace App\Evaluator\Domain;

use App\Evaluator\Contract\ExpressionComparator;
use InvalidArgumentException;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionComparatorImpl implements ExpressionComparator
{
    private ExpressionLanguage $evaluator;

    public function __construct(ExpressionLanguage $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    public function isEqual(string $leftExpression, string $rightExpression): bool
    {
        $parts = explode('=', $leftExpression . $rightExpression);

        if (count($parts) == 2) {
            $leftExpression = trim($parts[0]);
            $rightExpression = trim($parts[1]);
        } else if (count($parts) > 2) {
            throw new InvalidArgumentException("Expression must contain exactly one '=' operator.");
        }


        return $this->evaluator->evaluate($leftExpression) === $this->evaluator->evaluate($rightExpression);
    }
}
