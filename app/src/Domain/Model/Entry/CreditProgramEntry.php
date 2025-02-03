<?php

namespace App\Domain\Model\Entry;

class CreditProgramEntry
{
    private ?int $id;
    private ?string $title;
    private ?int $initialPayment;
    private ?int $loanTerm;
    private ?int $interestRate;

    /**
     * @param string|null $title
     */
    public function __construct(?array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $conditions = is_string($data['conditions']) ? json_decode($data['conditions'], true) : $data['conditions'];
        [$lTmin, $lTmax] = $conditions['loanTerm'];
        [$iPmin, $iPmax] = $conditions['initialPayment'];
        $keyItRate = isset($data['interestRate']) ? 'interestRate' : 'interest_rate';
        [$irsMin, $irsMax] = is_string($data[$keyItRate]) ? json_decode($data[$keyItRate], true) : $data[$keyItRate];

        $this->loanTerm = rand($lTmin, $lTmax);
        $this->initialPayment = max($iPmin, $iPmax);
        $this->interestRate = rand($irsMin, $irsMax);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getInitialPayment(): ?int
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function getInterestRate(): ?int
    {
        return $this->interestRate;
    }

    public function getMonthlyPayment(?int $price = null, ?int $loanTerm = null)
    {
        if ($this->id == 1) {
            return rand(9800, 10000);
        } else {
            if((null !== $price) && ($loanTerm !== null)){
                return ($price / $loanTerm) + (($price / $loanTerm) * ($this->interestRate / 1000));
            }

            $price = $this->initialPayment * $this->loanTerm;
            return ($price / $this->loanTerm) + (($price / $this->loanTerm) * ($this->interestRate / 1000));
        }
    }
}