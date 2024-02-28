<?php

namespace App\Testing\Tests;

use App\Evaluator\Contract\ExpressionComparator;
use App\Testing\Domain\AnswersEvaluator;
use App\Testing\Domain\Option;
use App\Testing\Domain\Question;
use PHPUnit\Framework\TestCase;

class ExpressionComparatorImplTest extends TestCase
{
    private $comparator;

    protected function setUp(): void
    {
        $this->comparator = $this->createMock(ExpressionComparator::class);
        $this->options = [];
        for ($i = 1; $i <= 5; $i++) {
            $option = $this->createMock(Option::class);
            $option
                ->method('getOptionId')
                ->willReturn($i);

            $option
                ->method('getExpression')
                ->willReturn((string)$i);

            $this->options[] = $option;
        }

        $this->question = $this->createMock(Question::class);
        $this->question
            ->method('getOptions')
            ->willreturn($this->options);
    }

    /**
     * @dataProvider provideCases
     */
    public function testCompare(bool $expectedResult, array $selectedOptions, array $correctOptions): void
    {
        $this->comparator->method('isEqual')
            ->willReturnCallback(function ($_ignored, $optionIndex) use ($correctOptions) {
                return in_array($optionIndex, $correctOptions);
            });

        $evaluator = new AnswersEvaluator([$this->question], $this->comparator);
        $isCorrectAnswer = $evaluator->compare($selectedOptions)->getCorrectAnswers();

        $this->assertEquals($expectedResult, $isCorrectAnswer);
    }

    public static function provideCases(): array
    {
        return [
            'no selected options' => [false, [], [1, 2]],
            'one of is wrong' => [false, [1, 3], [1, 2]],
            'one of is correct' => [true, [1], [1, 2]],
            'one to one is correct' => [true, [1, 2], [1, 2]],
        ];
    }
}
