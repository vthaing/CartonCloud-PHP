<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 11:12 AM
 */

namespace App\Factory;


use App\Entity\PurchaseOrderProduct;

class PurchaseOrderProductFactory
{
    /**
     * @var ProductFactory
     */
    private $productFactory;

    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    public function createPurchaseOrderProductFromCloudData($purchaseOrderProduct)
    {
        $entity = new PurchaseOrderProduct();
        $entity->setId($purchaseOrderProduct->id);
        $entity->setUnitQuantityInitial($purchaseOrderProduct->unit_quantity_initial);
        $product = $this->productFactory->createFromCloudData($purchaseOrderProduct->Product);
        $entity->setProduct($product);
        //$entity->setRawData($purchaseOrderProduct);

        return $entity;

    }
}