<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\BaseController;
use App\DataMapper\V1\RequestMapper;
use App\Domain\Model\Entry\RequestEntry;
use App\Domain\Model\Request\CreditProgramBodyRequest;
use App\Entity\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/request", requirements={"_locale": "en|ru"}, name="request_")
 * @OA\Tag(name="Request")
 */
class RequestController extends BaseController
{
    /**
     * @Route("", name="index", methods={"POST"})
     * @OA\RequestBody(@Model(type=CreditProgramBodyRequest::class))
     * @OA\Response(
     *     response="200",
     *     description="Result saved satus",
     *     @Model(type=RequestMapper::class)
     *   )
     */
    public function index(HttpRequest $request, ValidatorInterface $validator, ManagerRegistry $doctrine, RequestMapper $mapper): JsonResponse
    {
        // Сохранение заявки с указанными параметрами из кредитной формы
        try {
            $errors = $validator->validate($request->toArray());
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }
//            $reqSave = new Request();
//            $reqSave->setCarId($request->get('carId'));
//            $reqSave->setProgramId($request->get('programId'));
//            $reqSave->setInitialPayment($request->get('initialPayment'));
//            $reqSave->setLoanTerm($request->get('loanTerm'));
//            $em = $doctrine->getManager();
//            $em->persist($reqSave);
//            $em->flush();
        } catch (\Exception $e) {
            return $this->json($mapper->from(new RequestEntry(false)));
        }
        return $this->json($mapper->from(new RequestEntry(true))->map());
    }
}
