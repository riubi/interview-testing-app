<?php

namespace App\Testing\Infrastructure;

use App\Testing\Domain\Question;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "test_results")]
class TestResultEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'test_result_id', type: "integer")]
    private int $testResultId;

    #[ORM\Column(name: "correct_answers", type: "integer")]
    private int $correctAnswers;

    #[ORM\Column(name: "wrong_answers", type: "integer")]
    private int $wrongAnswers;

    public function __construct(int $correctAnswers, int $wrongAnswers)
    {
        $this->correctAnswers = $correctAnswers;
        $this->wrongAnswers = $wrongAnswers;
    }
}
