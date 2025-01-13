<?php
// src/Service/CalculatorService.php
namespace App\Service;

use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;

class CalculatorService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Effectue le calcul et sauvegarde l'opération
     */
    public function calculate(float $first, float $second, string $operator): float
    {
        $result = match ($operator) {
            '+' => $first + $second,
            '-' => $first - $second,
            '*' => $first * $second,
            '/' => $this->divide($first, $second),
            default => throw new \InvalidArgumentException('Opérateur non valide')
        };

        $this->saveOperation($first, $second, $operator, $result);

        return $result;
    }

    /**
     * Gère la division avec vérification de division par zéro
     */
    private function divide(float $first, float $second): float
    {
        if ($second === 0.0) {
            throw new \DivisionByZeroError('Division par zéro impossible');
        }
        return $first / $second;
    }

    /**
     * Sauvegarde l'opération dans la base de données
     */
    private function saveOperation(float $first, float $second, string $operator, float $result): void
    {
        $operation = new Operation();
        $operation->setFirstNumber($first);
        $operation->setSecondNumber($second);
        $operation->setOperator($operator);
        $operation->setResult($result);

        $this->entityManager->persist($operation);
        $this->entityManager->flush();
    }

    /**
     * Récupère l'historique des opérations
     * @return Operation[]
     */
    public function getHistory(int $limit = 10): array
    {
        return $this->entityManager
            ->getRepository(Operation::class)
            ->findHistory($limit);
    }
}