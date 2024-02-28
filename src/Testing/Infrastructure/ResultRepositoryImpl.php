<?php

namespace App\Testing\Infrastructure;

use App\Testing\Domain\ResultRepository;
use App\Testing\Domain\TestingResult;
use App\Testing\Domain\TestingStats;
use Doctrine\ORM\EntityManagerInterface;

class ResultRepositoryImpl implements ResultRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(TestingResult $result): void
    {
        $testResultEntity = new TestResultEntity($result->getCorrectAnswers(), $result->getWrongAnswers());

        $this->entityManager->persist($testResultEntity);
        $this->entityManager->flush();
    }

    public function getStats(): TestingStats
    {
        $results = $this->entityManager
            ->getRepository(TestResultEntity::class)
            ->createQueryBuilder('tr')
            ->select('COUNT(tr.testResultId) as submittedResults',
                'SUM(tr.correctAnswers) as correctAnswers',
                'SUM(tr.wrongAnswers) as wrongAnswers')
            ->getQuery()
            ->getSingleResult();

        return new TestingStats((int)$results['submittedResults'], (int)$results['correctAnswers'], (int)$results['wrongAnswers']);
    }

    public function clearAll(): void
    {
        $this->entityManager
            ->getRepository(TestResultEntity::class)
            ->createQueryBuilder('tr')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
