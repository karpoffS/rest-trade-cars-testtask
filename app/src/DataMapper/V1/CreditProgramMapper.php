<?php

namespace App\DataMapper\V1;

use App\DataMapper\BaseMapper;
use App\Domain\Model\Entry\CreditProgramEntry;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *      schema="CreditProgramMapper",
 *      type="object",
 *      title="CreditProgramMapper",
 *  	@OA\Property(property="programId", type="integer", example="1"),
 *  	@OA\Property(property="interestRate", type="number", format="float", example="12.3"),
 *  	@OA\Property(property="monthlyPayment", type="integer", example="9856"),
 *      @OA\Property(property="title", type="string", example="Alfa Energy")
 *  )
 */
class CreditProgramMapper extends BaseMapper
{
    /**
     * @param CreditProgramEntry $data
     * @return array
     */
    protected function toArray($data): array
    {
        return [
            'programId' => $data->getId(),
            'interestRate' => $data->getInterestRate() / 100,
            'monthlyPayment' => floor($data->getMonthlyPayment($this->getAdditional('price'), $this->getAdditional('loanTerm'))),
            'title' => $data->getTitle()
        ];
    }
}