<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\BaseController;
use App\DataMapper\V1\CarMapper;
use App\DataMapper\V1\CarShortMapper;
use App\Entity\Car;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\{HttpFoundation\JsonResponse, HttpFoundation\Request, Routing\Annotation\Route};
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/v1/cars", requirements={"_locale": "en|ru"}, name="cars_")
 * @OA\Tag(name="Cars")
 */
class CarsController extends BaseController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @OA\Response(
     *      response=200,
     *      description="Returns the car collection",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=CarShortMapper::class))
     *      )
     * )
     */
    public function index(ManagerRegistry $doctrine, CarShortMapper $mapper): JsonResponse
    {
        $carRepository = $doctrine->getRepository(Car::class);
        return $this->json($mapper->fromCollection($carRepository->findAll())->map());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      description="ID автомобиля",
     *      @OA\Schema(type="integer")
     *   )
     * @OA\Response(
     *    response="200",
     *    description="All information about the car",
     *    @Model(type=CarMapper::class)
     *  )
     */
    public function show(Request $request, ManagerRegistry $doctrine, CarMapper $mapper): JsonResponse
    {
        $carRepository = $doctrine->getRepository(Car::class);
        return $this->json($mapper->from($carRepository->find($request->get('id')))->map());
    }
}
