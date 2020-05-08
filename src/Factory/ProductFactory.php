<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 11:16 AM
 */

namespace App\Factory;


use App\Entity\Product;

class ProductFactory
{
    /**
     * Create product from raw data array
     *
     * @param $product
     *
     * @return Product
     */
    public function createFromCloudData($product)
    {
        $entity = new Product();

        $entity->setId($product->id);
        $entity->setName($product->name);
        $entity->setProductTypeId($product->product_type_id);
        $entity->setVolume($product->volume);
        $entity->setWeight($product->weight);
        //$entity->setRawData($product);

        return $entity;
    }

}