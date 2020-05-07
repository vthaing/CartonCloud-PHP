<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/7/2020
 * Time: 8:45 PM
 */

namespace App\Service;


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

    public function __construct($clientConfig = [])
    {
        $this->client = new Client($clientConfig);
    }

    /**
     * Get purchase orders by ids
     *
     * @param array $purchaseOrderIds
     *
     * @return Response[]
     */
    public function getPurchaseOrdersByIds($purchaseOrderIds = [])
    {
        $requests = [];
        foreach ($purchaseOrderIds as $orderId) {
            $this->createPurchaseOrderRequest($orderId);
        }

        return $this->sendAsyncRequests($requests);
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
        $request = new Request('GET',"/CartonCloud_Demo/PurchaseOrders/$id", ['query' => ['version'=>5, 'assocuated'=> 'true']]);
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
        $responses = settle($promises)->wait();
        return $responses;
    }

}