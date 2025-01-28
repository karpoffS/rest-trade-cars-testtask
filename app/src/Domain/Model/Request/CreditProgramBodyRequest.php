<?php

namespace App\Domain\Model\Request;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @OA\Schema(
 *      schema="CreditProgramBodyRequest",
 *      type="object",
 *      title="CreditProgramBodyRequest"
 *  )
 */
class CreditProgramBodyRequest
{
    /**
     * @OA\Property(property="carId", type="integer", example="1")
     * @Assert\NotBlank()
     * @Assert\Type(type="interger")
     * @var int|null
     */
    private ?int $carId;

    /**
     * @OA\Property(property="programId", type="integer", example="1")
     * @Assert\NotBlank()
     * @Assert\Type(type="interger")
     * @var int|null
     */
    private ?int $programId;

    /**
     * @OA\Property(property="initialPayment", type="integer", example="20000056")
     * @Assert\NotBlank()
     * @Assert\Type(type="interger")
     * @var int|null
     */
    private ?int $initialPayment;

    /**
     * @OA\Property(property="loanTerm", type="integer", example="64")
     * @Assert\NotBlank()
     * @Assert\Type(type="interger")
     * @var int|null
     */
    private ?int $loanTerm;

    public function getCarId(): ?int
    {
        return $this->carId;
    }

    public function setCarId(?int $carId): self
    {
        $this->carId = $carId;
        return $this;
    }

    public function getProgramId(): ?int
    {
        return $this->programId;
    }

    public function setProgramId(?int $programId): self
    {
        $this->programId = $programId;
        return $this;
    }

    public function getInitialPayment(): ?int
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(?int $initialPayment): self
    {
        $this->initialPayment = $initialPayment;
        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(?int $loanTerm): self
    {
        $this->loanTerm = $loanTerm;
        return $this;
    }
}