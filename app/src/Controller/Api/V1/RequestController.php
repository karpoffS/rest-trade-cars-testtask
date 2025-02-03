<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\BaseController;
use App\DataMapper\V1\RequestMapper;
use App\Domain\Model\Entry\RequestEntry;
use App\Domain\Requests\CreditProgramBodyRequest;
use App\Entity\Request;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/request", requirements={"_locale": "en|ru"}, name="request_")
 * @OA\Tag(name="Request")
 */
class RequestController extends BaseController
{
    /**
     * @Route("", name="index", methods={"POST"})
     * @OA\Response(
     *     response="200",
     *     description="Result saved satus",
     *     @Model(type=RequestMapper::class)
     *   )
     */
    public function index(CreditProgramBodyRequest $request, ManagerRegistry $doctrine, RequestMapper $mapper): JsonResponse
    {
        // Сохранение заявки с указанными параметрами из кредитной формы
        try {
            if (count($errors = $request->validate()) > 0) {
               throw new \RuntimeException((string) $errors);
            }

            $reqSave = new Request();
            $reqSave->setCarId($request->carId);
            $reqSave->setProgramId($request->programId);
            $reqSave->setInitialPayment($request->initialPayment);
            $reqSave->setLoanTerm($request->loanTerm);
            $em = $doctrine->getManager();
            $em->persist($reqSave);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json($mapper->from(new RequestEntry(false, $e->getMessage()))->map());
        }
        return $this->json($mapper->from(new RequestEntry(true))->map());
    }
}
