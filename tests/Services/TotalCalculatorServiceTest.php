<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 4:35 PM
 */

namespace App\Tests\Services;
use App\Entity\Product;
use App\Entity\PurchaseOrderProduct;
use App\Service\Calculators\VolumeCalculator;
use App\Service\Calculators\WeighCalculator;
use App\Service\TotalCalculatorService;
use App\Service\CartonCloudService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TotalCalculatorServiceTest extends WebTestCase
{
    /**
     * @var TotalCalculatorService
     */
    protected $totalCalculatorService;
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
        $this->totalCalculatorService = self::$container->get('App\Service\TotalCalculatorService');
        $this->cartonCloundService = self::$container->get('App\Service\CartonCloudService');
    }

    public function testCalculateTotal()
    {
        $purchaseOrderProduct = $this->preparePurchaseOrderProductToTest();
        $totals = $this->totalCalculatorService->calculateTotal($purchaseOrderProduct);
        $this->assertIsArray($totals);
        foreach ($totals as $item) {
            $this->assertArrayHasKey('product_type_id', $item);
            $this->assertArrayHasKey('total', $item);
        }
    }

    public function testGetCalculatorsForAPurchaseOrderProduct()
    {
        $purchaseOrderProduct = new PurchaseOrderProduct();
        $productType1 = new Product();
        $productType1->setProductTypeId(1);
        $purchaseOrderProduct->setProduct($productType1);

        $calculators = $this->totalCalculatorService->getCalculatorsForAPurchaseOrderProduct($purchaseOrderProduct);
        $this->assertIsArray($calculators);
        $this->assertTrue(count($calculators) === 1);
        $this->assertTrue($calculators[0] instanceof WeighCalculator);

        $productType2 = new Product();
        $productType2->setProductTypeId(2);
        $purchaseOrderProduct->setProduct($productType2);

        $calculators = $this->totalCalculatorService->getCalculatorsForAPurchaseOrderProduct($purchaseOrderProduct);
        $this->assertIsArray($calculators);
        $this->assertTrue(count($calculators) === 1);
        $this->assertTrue($calculators[0] instanceof VolumeCalculator);
    }

    protected function preparePurchaseOrderProductToTest()
    {
        return $this->cartonCloundService->getPurchaseOrderProductsByOrderIds([2344, 2345, 2346]);
    }


}