<?php

namespace App\Domain\Model\Request;


class CreditProgramRequest
{
    private ?string $title;
    private ?int $initialPayment;
    private ?int $loanTerm;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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