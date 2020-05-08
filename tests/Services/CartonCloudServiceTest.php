<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 4:01 PM
 */

namespace App\Tests\Services;
use App\Entity\PurchaseOrderProduct;
use App\Service\CartonCloudService;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CartonCloudServiceTest extends WebTestCase
{
    /**
     * @var CartonCloudService
     */
    protected $cartonCloundService;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $container = self::$kernel->getContainer();
        // gets the special container that allows fetching private services
        $this->cartonCloundService = self::$container->get('App\Service\CartonCloudService');
    }

    public function testCreatePurchaseOrderRequest()
    {
        $request = $this->cartonCloundService->createPurchaseOrderRequest(100);
        $this->assertTrue(($request instanceof  Request));
        $this->assertStringContainsString("/CartonCloud_Demo/PurchaseOrders/" . 100, $request->getUri());

        $request = $this->cartonCloundService->createPurchaseOrderRequest(151);
        $this->assertTrue(($request instanceof  Request));
        $this->assertStringContainsString("/CartonCloud_Demo/PurchaseOrders/" . 151, $request->getUri());
        $this->assertStringContainsString("?version=5&associated=true", $request->getUri());
    }

    public function testGetPurchaseOrderProductsByOrderIds()
    {
        $result = $this->cartonCloundService->getPurchaseOrderProductsByOrderIds([2344, 2345, 2346]);
        $this->assertIsArray($result);
        foreach ($result as $item) {
            $this->assertInstanceOf(PurchaseOrderProduct::class, $item);
        }
    }



}