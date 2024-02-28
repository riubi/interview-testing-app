<?php

namespace App\Testing\Infrastructure;

use App\Testing\Domain\Option;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "options")]
class OptionEntity implements Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "option_id", type: "integer")]
    private int $optionId;

    #[ORM\Column(type: "text")]
    private string $expression;

    #[ORM\ManyToOne(targetEntity: QuestionEntity::class, inversedBy: 'options')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'question_id')]
    private QuestionEntity|null $question = null;

    public function getOptionId(): int
    {
        return $this->optionId;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function jsonSerialize(): array
    {
        return [
            'optionId' => $this->optionId,
            'expression' => $this->expression
        ];
    }
}
