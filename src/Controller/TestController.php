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
        $responseData = $this->prepareDataForResponse($totalGroupedByProductType);

        return new JsonResponse($responseData);
    }

    /**
     **
     * @Route("/")
     * @param Request $request
     * @return JsonResponse
     */
    public function actionHome()
    {
        return new JsonResponse('ok');

    }

    /**
     * Prepare data for response
     * @param $data
     * @return array
     */
    protected function prepareDataForResponse($data)
    {
        $result = ['result' => []];
        foreach ($data as $productTypeId => $total) {
            $resultItem = [];
            $resultItem['product_type_id'] = $productTypeId;
            $resultItem['total'] = $total;
            $result['result'][] = $resultItem;
        }

        return $result;
    }

}