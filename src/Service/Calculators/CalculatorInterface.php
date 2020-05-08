<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 10:50 AM
 */

namespace App\Service\Calculators;


use App\Entity\PurchaseOrderProduct;

interface CalculatorInterface
{
    public function calculate(PurchaseOrderProduct $purchaseOrderProduct);
}