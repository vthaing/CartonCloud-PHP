<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/7/2020
 * Time: 8:45 PM
 */

namespace App\Service;


use App\Entity\PurchaseOrderProduct;
use App\Factory\PurchaseOrderProductFactory;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\Promise;
use function GuzzleHttp\Promise\settle;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class CartonCloudService
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var PurchaseOrderProductFactory
     */
    private $purchaseOrderProductFactory;

    public function __construct(PurchaseOrderProductFactory $purchaseOrderProductFactory, $clientConfig = [])
    {
        $this->client = new Client($clientConfig);
        $this->purchaseOrderProductFactory = $purchaseOrderProductFactory;
    }

    /**
     * Get purchase order product from raw data
     *
     * @param array $purchaseOrderIds
     *
     * @return PurchaseOrderProduct[]
     */
    public function getPurchaseOrderProductsByOrderIds($purchaseOrderIds = [])
    {
        $result = [];
        $purchaseOrders = $this->getPurchaseOrdersByIds($purchaseOrderIds);
        foreach ($purchaseOrders as $purchaseOrder) {
            if (!property_exists($purchaseOrder, 'PurchaseOrderProduct')) {
                continue;
            }

            foreach ($purchaseOrder->PurchaseOrderProduct as $rawPurchaseOrderProduct) {
                $purchaseOrderProduct = $this->purchaseOrderProductFactory->createPurchaseOrderProductFromCloudData($rawPurchaseOrderProduct);
                $result[] = $purchaseOrderProduct;
            }
        }

        return $result;
    }

    /**
     * Get purchase orders by ids
     *
     * @param array $purchaseOrderIds
     *
     * @return []
     */
    public function getPurchaseOrdersByIds($purchaseOrderIds = [])
    {
        $requests = [];
        foreach ($purchaseOrderIds as $orderId) {
            $requests[] = $this->createPurchaseOrderRequest($orderId);
        }

        $responses = $this->sendAsyncRequests($requests);
        $result = [];
        foreach ($responses as $response) {
            $responseBody = $response->getBody();
            $responseData = json_decode($responseBody->getContents());
            if (property_exists($responseData,'data')) {
                $result[] = $responseData->data;
            }
        }

        return $result;
    }

    /**
     * Create request PuchaseOrder by id
     *
     * @param $id
     *
     * @return Request
     */
    public function createPurchaseOrderRequest($id)
    {
        $request = new Request('GET',"/CartonCloud_Demo/PurchaseOrders/$id?version=5&associated=true");
        return $request;
    }


    /**
     * Send Async request and return the response
     *
     * @param $requests
     *
     * @return Response[]
     */
    public function sendAsyncRequests($requests)
    {
        $promises = [];
        foreach ($requests as $request) {
            $promises[] = $this->client->sendAsync($request);
        }

        // Wait for the requests to complete, even if some of them fail
        $responses = \GuzzleHttp\Promise\unwrap($promises);
        return $responses;
    }

}