<?php

namespace App\Testing\Infrastructure;

use App\Testing\Domain\Testing;
use App\Testing\Domain\TestingRepository;
use Doctrine\ORM\EntityManagerInterface;
use JsonSerializable;

class TestingRepositoryImpl implements TestingRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTest(): Testing
    {
        $questions = $this->entityManager
            ->getRepository(QuestionEntity::class)
            ->findAll();

        return new Testing($questions);
    }
}
