<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/7/2020
 * Time: 4:48 PM
 */

namespace App\Controller;
use App\Service\CartonCloudService;
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
        CartonCloudService $cartonCloudService
    ) {

        $requestData = json_decode($request->getContent());
        $purchaseOrders = $cartonCloudService->getPurchaseOrdersByIds($requestData->purchase_order_ids);
        return new JsonResponse();
    }

}