<?php

namespace App\Testing\Domain;

interface ResultRepository
{

    public function save(TestingResult $result): void;

    public function getStats(): TestingStats;

    public function clearAll(): void;
}
