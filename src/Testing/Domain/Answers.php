<?php

namespace App\Testing\Domain;

interface Answers
{
    public function compare(array $selectedOptions): TestingResult;
}
