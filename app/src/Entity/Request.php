<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $carId;

    /**
     * @ORM\Column(type="integer")
     */
    private $programId;

    /**
     * @ORM\Column(type="integer")
     */
    private $initialPayment;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanTerm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarId(): ?int
    {
        return $this->carId;
    }

    public function setCarId(int $carId): self
    {
        $this->carId = $carId;

        return $this;
    }

    public function getProgramId(): ?int
    {
        return $this->programId;
    }

    public function setProgramId(int $programId): self
    {
        $this->programId = $programId;

        return $this;
    }

    public function getInitialPayment(): ?int
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(string $initialPayment): self
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): self
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }
}
