<?php

namespace Model;


use Service\DAO;
use Model\Product;
use Exception;


class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($body)
    {

        $this->setSku($body['sku']);
        $this->setName($body['name']);
        $this->setPrice($body['price']);
        $this->setProductType($body['product_type']);
        $this->setHeight($body['height']);
        $this->setWidth($body['width']);
        $this->setLength($body['length']);
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getProductType()
    {
        return $this->product_type;
    }

    public function setProductType($product_type)
    {
        $this->product_type = $product_type;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function add($furniture)
    {

        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type, height, width, length)
                    VALUES (:sku, :name, :price, :product_type, :height, :width, :length)";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $furniture->getSku());
            $stman->bindValue(":name", $furniture->getName());
            $stman->bindValue(":price", $furniture->getPrice());
            $stman->bindValue(":product_type", $furniture->getProductType());
            $stman->bindValue(':height', $furniture->getHeight());
            $stman->bindValue(':width', $furniture->getWidth());
            $stman->bindValue(':length', $furniture->getLength());
            $stman->execute();

        } catch (Exception $e) {
            throw new Exception("error registering the product" . $e->getmessage());
        }
    }
}