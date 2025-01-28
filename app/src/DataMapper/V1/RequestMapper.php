<?php

namespace App\DataMapper\V1;

use App\DataMapper\BaseMapper;
use App\Domain\Model\Entry\RequestEntry;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="RequestMapper",
 *      type="object",
 *      title="RequestMapper",
 *  	@OA\Property(property="success", type="boolean", example="true")
 *  )
 */
class RequestMapper extends BaseMapper
{
    /**
     * @param RequestEntry $data
     * @return array
     */
    protected function toArray($data): array
    {
        return [
            'success' => $data->getSuccess(),
        ];
    }
}