<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/7/2020
 * Time: 4:48 PM
 */

namespace App\Controller;
use App\Service\CartonCloudService;
use App\Service\TotalCalculatorService;
use BearClaw\Warehousing\PurchaseOrderService;
use BearClaw\Warehousing\TotalsCalculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{


    /**
     * @Route("/test", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function actionTest(
        Request $request,
        CartonCloudService $cartonCloudService,
        TotalCalculatorService $totalCalculatorService
    ) {
        $requestData = json_decode($request->getContent());

        $purchaseOrderProducts = $cartonCloudService->getPurchaseOrderProductsByOrderIds($requestData->purchase_order_ids);
        $totalGroupedByProductType = $totalCalculatorService->calculateTotal($purchaseOrderProducts);

        return new JsonResponse(['result' => $totalGroupedByProductType]);
    }

    /**
     **
     * @Route("/")
     * @param Request $request
     * @return JsonResponse
     */
    public function actionHome()
    {
        $totalCalculator = new TotalsCalculator();
        $totalCalculator->generateReport([2344, 2345, 2346]);
        return new JsonResponse('ok');

    }

}