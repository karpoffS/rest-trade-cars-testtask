<?php

namespace App\Application\DTO;


use App\Domain\Model\ValueObjects\{CreditProgramInitialPayment, CreditProgramLoanTerm, CreditProgramTitle};
use Symfony\Component\HttpFoundation\Request;

class CreditProgram
{
    private ?int $id;
    private ?CreditProgramTitle $title;
    private CreditProgramInitialPayment $initialPayment;
    private CreditProgramLoanTerm $loanTerm;

    /**
     * @param int|null $id
     * @param CreditProgramTitle $title
     * @param CreditProgramInitialPayment $initialPayment
     * @param CreditProgramLoanTerm $loanTerm
     */
    public function __construct(
        ?int $id,
        ?CreditProgramTitle $title,
        CreditProgramInitialPayment $initialPayment,
        CreditProgramLoanTerm $loanTerm
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public static function fromRequest(Request $request, ?int $order_id = null): self
    {
        return new self(
            $order_id,
            $request->get('title') !== null ? new CreditProgramTitle($request->get('title')) : null,
            new CreditProgramInitialPayment($request->get('initialPayment')),
            new CreditProgramLoanTerm($request->get('loanTerm')),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?CreditProgramTitle
    {
        return $this->title;
    }

    public function getInitialPayment(): CreditProgramInitialPayment
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): CreditProgramLoanTerm
    {
        return $this->loanTerm;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'initialPayment' => $this->initialPayment,
            'loanTerm' => $this->loanTerm,
        ];
    }
}