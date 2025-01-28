<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\BaseController;
use App\DataMapper\V1\CreditProgramMapper;
use App\Domain\Model\Entry\CreditProgramEntry;
use App\Domain\Model\Request\CreditProgramRequest;
use App\Entity\CreditProgram;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\{HttpFoundation\JsonResponse, HttpFoundation\Request as HttpRequest, Routing\Annotation\Route};
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/v1/credit", requirements={"_locale": "en|ru"}, name="credit_")
 * @OA\Tag(name="Credit")
 */
class CreditController extends BaseController
{
    /**
     * @Route("/calculate", name="calculate", methods={"GET"})
     * @OA\Response(
     *       response=200,
     *       description="Returns the car collection",
     *       @Model(type=CreditProgramMapper::class)
     *  )
     * @OA\Parameter(
     *     name="price",
     *     in="query",
     *     required=true,
     *     description="Цена автомобиля",
     *     @OA\Schema(type="integer")
     *  )
     * @OA\Parameter(
     *     name="initialPayment",
     *     in="query",
     *     required=true,
     *     description="Первоначальный взнос за кредит. В запросе отдаются рубли с копейками(точность до десятых долей). Пример: 200000.56",
     *     @OA\Schema(type="float")
     *  )
     * @OA\Parameter(
     *     name="loanTerm",
     *     in="query",
     *     required=true,
     *     description="Срок кредита в месяцах",
     *     @OA\Schema(type="integer")
     *  )
     */
    public function calculate(HttpRequest $request, ManagerRegistry $doctrine, CreditProgramMapper $mapper): JsonResponse
    {
        $price = (int) $request->get('price');
        $initialPayment = floatval($request->get('initialPayment'));
        $loanTerm = intval($request->get('loanTerm'));

        $repo = $doctrine->getManager()->getRepository(CreditProgram::class);
        /** @var CreditProgramEntry|null $program */
        $program = $repo->fetchByParams(
            (new CreditProgramRequest())->setInitialPayment($initialPayment)->setLoanTerm($loanTerm)
        );

        return $this->json(
            $mapper->from($program, ['price' => $price, 'loanTerm' => $loanTerm])->map()
        );
    }
}
