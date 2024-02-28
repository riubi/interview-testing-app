<?php

namespace App\Evaluator\Contract;

interface ExpressionComparator
{
    public function isEqual(string $leftExpression, string $rightExpression): bool;
}
