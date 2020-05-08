<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 1:27 PM
 */

namespace BearClaw\Warehousing;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class PurchaseOrderService
{
    private $client;

    public function __construct()
    {
        $clientConfig = [
            'base_uri'=>'localhost:8000',
            'auth' => ['demo', 'pwd1234'],
            'verify' => false
        ];
        $this->client = new Client($clientConfig);
    }

    /**
     * Call to local host API to calculate total
     */
    public function calculateTotals($ids)
    {

        $requestBody = ['purchase_order_ids' => $ids];
        $response = $this->client->request('POST', '/test', ['body' => json_encode($requestBody)]);
        $responseContent =  json_decode($response->getBody()->getContents(), true);
        return $responseContent['result'];
    }
}