<?php

namespace App\Testing\Domain;

use JsonSerializable;

interface Option extends JsonSerializable
{
    public function getOptionId(): int;

    public function getExpression(): string;
}
