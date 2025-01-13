<?php
// src/Controller/CalculatorController.php
namespace App\Controller;

use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    public function __construct(
        private CalculatorService $calculatorService
    ) {}

    #[Route('/', name: 'app_calculator')]
    public function index(): Response
    {
        $history = $this->calculatorService->getHistory();
        return $this->render('calculator/index.html.twig', [
            'history' => $history
        ]);
    }

    #[Route('/calculate', name: 'calculator_calculate', methods: ['POST'])]
    public function calculate(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$this->isValidData($data)) {
                throw new \InvalidArgumentException('Données invalides');
            }

            $result = $this->calculatorService->calculate(
                (float) $data['first'],
                (float) $data['second'],
                $data['operator']
            );

            return $this->json(['result' => $result]);
            
        } catch (\DivisionByZeroError $e) {
            return $this->json(['error' => 'Division par zéro impossible'], 400);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Une erreur est survenue'], 500);
        }
    }

    #[Route('/history', name: 'calculator_history', methods: ['GET'])]
    public function history(): JsonResponse
    {
        $history = $this->calculatorService->getHistory();
        return $this->json($history);
    }

    private function isValidData(?array $data): bool
    {
        return $data !== null 
            && isset($data['first'], $data['second'], $data['operator'])
            && is_numeric($data['first'])
            && is_numeric($data['second'])
            && in_array($data['operator'], ['+', '-', '*', '/']);
    }
}