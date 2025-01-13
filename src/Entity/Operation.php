<?php
// src/Entity/Operation.php
namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $firstNumber = null;

    #[ORM\Column]
    private ?float $secondNumber = null;

    #[ORM\Column(length: 1)]
    private ?string $operator = null;

    #[ORM\Column]
    private ?float $result = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstNumber(): ?float
    {
        return $this->firstNumber;
    }

    public function setFirstNumber(float $firstNumber): static
    {
        $this->firstNumber = $firstNumber;
        return $this;
    }

    public function getSecondNumber(): ?float
    {
        return $this->secondNumber;
    }

    public function setSecondNumber(float $secondNumber): static
    {
        $this->secondNumber = $secondNumber;
        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): static
    {
        $this->operator = $operator;
        return $this;
    }

    public function getResult(): ?float
    {
        return $this->result;
    }

    public function setResult(float $result): static
    {
        $this->result = $result;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}