<?php

namespace App\Evaluator\Tests;

use App\Evaluator\Contract\ExpressionComparator;
use App\Evaluator\Domain\ExpressionComparatorImpl;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionComparatorImplTest extends TestCase
{
    private ExpressionComparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new ExpressionComparatorImpl(new ExpressionLanguage());
    }

    /**
     * @dataProvider provideCases
     */
    public function testIsEqual($expectedResult, $leftExpression, $rightExpression): void
    {
        self::assertEquals($expectedResult, $this->comparator->isEqual($leftExpression, $rightExpression));
    }

    /**
     * @return array
     */
    public static function provideCases(): array
    {
        return [
            'simple case' => [true, '1', '1'],
            'sum' => [true, '1 + 2 =', '4 - 1'],
            'multiply' => [false, '1 * 2 =', '1'],
            'false case' => [false, '1 + 2 =', '4'],
        ];
    }
}
