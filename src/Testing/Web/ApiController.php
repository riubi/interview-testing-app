<?php

namespace App\Testing\Web;

use App\Evaluator\Contract\ExpressionComparator;
use App\Testing\Domain\ResultRepository;
use App\Testing\Domain\TestingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/testing/questions', name: 'testing-questions', methods: 'GET')]
    public function questions(TestingRepository $questionRepository): Response
    {
        $test = $questionRepository->getTest();
        $test->randomize();

        return $this->json($test);
    }

    #[Route('/api/testing/evaluate', name: 'testing-evaluate', methods: 'POST')]
    public function evaluate(Request              $request,
                             ExpressionComparator $comparator,
                             TestingRepository    $questionRepository,
                             ResultRepository     $resultRepository): Response
    {

        $data = json_decode($request->getContent(), true);
        $selectedOptions = $data['selectedOptions'] ?? [];

        $result = $questionRepository
            ->getTest()
            ->evaluate($selectedOptions, $comparator, $resultRepository);

        return $this->json($result);
    }

    #[Route('/api/testing/results', name: 'testing-get-results', methods: 'GET')]
    public function getResults(ResultRepository $resultRepository): Response
    {
        $result = $resultRepository->getStats();

        return $this->json($result);
    }

    #[Route('/api/testing/results', name: 'testing-clear-results', methods: 'DELETE')]
    public function clearResults(ResultRepository $resultRepository): Response
    {
        $resultRepository->clearAll();

        return $this->json([]);
    }
}
