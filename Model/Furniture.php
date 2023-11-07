<?php

namespace Model;


use Exception;
use Service\DAO;
use Model\Product;


class Furniture extends Product
{
    private $height, $width, $length;
    

    public function __construct($body)
    {

        parent::__construct($body);
        $this->setHeight($body['height']);
        $this->setWidth($body['width']);
        $this->setLength($body['length']);
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

    public function post($product)
    {
        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type, height, width, length)
                    VALUES (:sku, :name, :price, :product_type, :height, :width, :length)";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $product->getSku());
            $stman->bindValue(":name", $product->getName());
            $stman->bindValue(":price", $product->getPrice());
            $stman->bindValue(":product_type", $product->getProductType());
            $stman->bindValue(':height', $product->getHeight());
            $stman->bindValue(':width', $product->getWidth());
            $stman->bindValue(':length', $product->getLength());
            $stman->execute();            

        } catch (Exception $e) {
            throw new Exception("error registering the product: " . $e->getmessage());
        }
    }
}