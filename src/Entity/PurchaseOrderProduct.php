<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 10:53 AM
 *
 * Contain some main properties of PurchaseOrderProduct.
 * All remains properties will be store in rawData
 */

namespace App\Entity;


class PurchaseOrderProduct
{
    private $id;
    /**
     * @var Product
     */
    private $product;
    private $unitQuantityInitial;
    private $rawData;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getUnitQuantityInitial()
    {
        return $this->unitQuantityInitial;
    }

    /**
     * @param mixed $unitQuantityInitial
     */
    public function setUnitQuantityInitial($unitQuantityInitial): void
    {
        $this->unitQuantityInitial = $unitQuantityInitial;
    }

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param mixed $rawData
     */
    public function setRawData($rawData): void
    {
        $this->rawData = $rawData;
    }

}