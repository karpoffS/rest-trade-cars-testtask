<?php

namespace App\Domain\Requests;

use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *      schema="CreditProgramBodyRequest",
 *      type="object",
 *      title="CreditProgramBodyRequest"
 *  )
 */
class CreditProgramBodyRequest extends BaseRequest
{
    /**
     * @OA\Property(property="carId", type="integer", example="1")
     * @var int|null
     */
    public ?int $carId;

    /**
     * @OA\Property(property="programId", type="integer", example="1")
     * @var int|null
     */
    public ?int $programId;

    /**
     * @OA\Property(property="initialPayment", type="integer", example="20000056")
     * @var int|null
     */
    public ?int $initialPayment;

    /**
     * @OA\Property(property="loanTerm", type="integer", example="64")
     * @var int|null
     */
    public ?int $loanTerm;
}