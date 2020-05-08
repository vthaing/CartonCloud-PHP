<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 12:00 AM
 */

namespace App\Service;


use App\Entity\PurchaseOrderProduct;
use App\Service\Calculators\CalculatorInterface;

class TotalCalculatorService
{
    private $formulaByTypeConfig;

    public function __construct($formulaByTypeConfig)
    {
        $this->formulaByTypeConfig = $formulaByTypeConfig;
    }



    /**
     * Calculate total grouped by product type id
     *
     * @param PurchaseOrderProduct[]  $purchaseOrderProducts
     *
     * @return array
     */
    public function calculateTotal($purchaseOrderProducts)
    {
        $totals = [];
        foreach ($purchaseOrderProducts as $item) {
            $productTypeId = $item->getProduct() ? $item->getProduct()->getProductTypeId() : null;
            //Do nothing when product type id is not existed
            if (!$productTypeId) {
                continue;
            }

            //Initialize sum by product type id
            if (!array_key_exists($productTypeId, $totals)) {
                $totals[$productTypeId] = 0;
            }

            $productPurchaseTotal = 0;
            $calculators = $this->getCalculatorsForAPurchaseOrderProduct($item);
            //Traverse all calculators and do calculate
            foreach ($calculators as $calculator) {
                $productPurchaseTotal += $calculator->calculate($item);
            }

            $totals[$productTypeId] += $productPurchaseTotal;
        }

        return $this->prepareTotalResult($totals);
    }

    protected function prepareTotalResult($totals) {
        $result = [];
        foreach ($totals as $productTypeId => $total) {
            $resultItem = [];
            $resultItem['product_type_id'] = $productTypeId;
            $resultItem['total'] = $total;
            $result[] = $resultItem;
        }

        return $result;
    }


    /**
     * Get calculators instances for a purchase order product
     *
     * @param PurchaseOrderProduct $purchaseOrderProduct
     *
     * @return CalculatorInterface[]
     */
    public function getCalculatorsForAPurchaseOrderProduct(PurchaseOrderProduct $purchaseOrderProduct)
    {
        $product = $purchaseOrderProduct->getProduct();
        if ($product && array_key_exists($product->getProductTypeId(), $this->formulaByTypeConfig)) {
            return $this->formulaByTypeConfig[$product->getProductTypeId()];
        }

        return [];

    }
}