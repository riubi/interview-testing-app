<?php

namespace App\Testing\Domain;

use Doctrine\Common\Collections\Collection;
use JsonSerializable;

interface Question extends JsonSerializable
{
    public function getQuestionId(): int;

    public function getExpression(): string;

    public function getOptions(): array;

    public function randomize(): void;
}
