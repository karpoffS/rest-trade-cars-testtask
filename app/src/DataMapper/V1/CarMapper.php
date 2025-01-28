<?php


namespace App\DataMapper\V1;


use App\DataMapper\BaseMapper;
use App\Entity\Car;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Schema(
 *      schema="CarMapper",
 *      type="object",
 *      title="CarMapper",
 *  	@OA\Property(property="id", type="integer"),
 *      @OA\Property(property="brand", ref=@Model(type=BrandMapper::class)),
 *      @OA\Property(property="model", ref=@Model(type=ModelMapper::class)),
 *      @OA\Property(property="photo", type="string"),
 *      @OA\Property(property="price", type="integer")
 *  )
 */
class CarMapper extends BaseMapper
{
    private BrandMapper $brandMapper;
    private ModelMapper $modelMapper;

    public function __construct(
        BrandMapper $brandMapper,
        ModelMapper $modelMapper
    )
    {
        $this->brandMapper = $brandMapper;
        $this->modelMapper = $modelMapper;
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
            'model' => $this->modelMapper->from($data->getModel())->map(),
            'photo' => $data->getPhoto(),
            'price' => $data->getPrice(),
        ];
    }
}
