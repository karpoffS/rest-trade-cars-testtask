<?php

namespace App\Entity;

use App\Repository\CreditProgramRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditProgramRepository::class)
 */
class CreditProgram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     */
    private $conditions = [];

    /**
     * @ORM\Column(type="json")
     */
    private $interestRate = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getInterestRate(): ?array
    {
        return $this->interestRate;
    }

    public function setInterestRate(array $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

}
