<?php

namespace App\DataMapper\V1;

use App\DataMapper\BaseMapper;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="BrandMapper",
 *      type="object",
 *      title="BrandMapper",
 *  	@OA\Property(property="id", type="integer"),
 *      @OA\Property(property="name", type="string")
 *  )
 */
class BrandMapper extends BaseMapper
{
    /**
     * @param $data
     * @return array
     */
    protected function toArray($data): array
    {
        return [
            'id' => $data->getId(),
            'name' => $data->getName(),
        ];
    }
}