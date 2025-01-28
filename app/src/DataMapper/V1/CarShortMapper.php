<?php


namespace App\DataMapper\V1;


use App\DataMapper\BaseMapper;
use App\Entity\Car;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Schema(
 *      schema="CarShortMapper",
 *      type="object",
 *      title="CarShortMapper",
 *  	@OA\Property(property="id", type="integer"),
 *      @OA\Property(property="brand", ref=@Model(type=BrandMapper::class)),
 *      @OA\Property(property="photo", type="string"),
 *      @OA\Property(property="price", type="integer")
 *  )
 */
class CarShortMapper extends BaseMapper
{
    private BrandMapper $brandMapper;

    public function __construct(BrandMapper $brandMapper)
    {
        $this->brandMapper = $brandMapper;
    }

    /**
     * @param Car $data
     * @return array
     */
    protected function toArray($data): array
    {
        return [
            'id' => $data->getId(),
            'brand' => $this->brandMapper->from($data->getBrand())->map(),
            'photo' => $data->getPhoto(),
            'price' => $data->getPrice(),
        ];
    }
}
