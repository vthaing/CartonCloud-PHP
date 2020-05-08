<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 10:52 AM
 */

namespace App\Service\Calculators;


use App\Entity\PurchaseOrderProduct;

class WeighCalculator implements CalculatorInterface
{
    public function calculate(PurchaseOrderProduct $purchaseOrderProduct)
    {
        return $purchaseOrderProduct->getUnitQuantityInitial() * $purchaseOrderProduct->getProduct()->getWeight();
    }

}