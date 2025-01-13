<?php
// tests/Service/CalculatorServiceTest.php
namespace App\Tests\Service;

use App\Service\CalculatorService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    private CalculatorService $calculatorService;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->calculatorService = new CalculatorService($this->entityManager);
    }

    /**
     * @dataProvider calculationProvider
     */
    public function testCalculate(float $first, float $second, string $operator, float $expected): void
    {
        $result = $this->calculatorService->calculate($first, $second, $operator);
        $this->assertEquals($expected, $result);
    }

    public function calculationProvider(): array
    {
        return [
            'addition' => [2, 3, '+', 5],
            'soustraction' => [5, 3, '-', 2],
            'multiplication' => [4, 3, '*', 12],
            'division' => [6, 2, '/', 3],
        ];
    }

    public function testDivisionByZero(): void
    {
        $this->expectException(\DivisionByZeroError::class);
        $this->calculatorService->calculate(5, 0, '/');
    }

    public function testInvalidOperator(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculatorService->calculate(5, 2, '%');
    }
}