<?php

namespace App\Testing\Infrastructure;

use App\Testing\Domain\Question;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "questions")]
class QuestionEntity implements Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'question_id', type: "integer")]
    private ?int $questionId;

    #[ORM\Column(type: "text")]
    private string $expression;

    #[ORM\OneToMany(targetEntity: OptionEntity::class, mappedBy: 'question')]
    private Collection $options;

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getOptions(): array
    {
        return $this->options->toArray();
    }

    public function randomize(): void
    {
        $randomizedOptions = $this->options->toArray();
        shuffle($randomizedOptions);
        $this->options = new ArrayCollection($randomizedOptions);
    }

    public function jsonSerialize(): array
    {
        return [
            'questionId' => $this->questionId,
            'expression' => $this->expression,
            'options' => $this->options->map(function (OptionEntity $option) {
                return $option->jsonSerialize();
            })->toArray(),
        ];
    }
}
