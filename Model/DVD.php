<?php

namespace Model;


use Exception;
use Service\DAO;
use Model\Product;


class DVD extends Product
{
    private $size;


    public function __construct($body)
    {
        parent::__construct($body);
        $this->setSize($body['size']);
    }    

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function post($product)
    {
        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type, size)
                    VALUES (:sku, :name, :price, :product_type, :size)";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $product->getSku());
            $stman->bindValue(":name", $product->getName());
            $stman->bindValue(":price", $product->getPrice());
            $stman->bindValue(":product_type", $product->getProductType());
            $stman->bindValue(':size', $product->getSize());
            $stman->execute();
            $response = ['Product added on database'];
            
            return $response;

        } catch (Exception $e) {

            throw new Exception("error registering the product: " . $e->getmessage());            
        }
    }
}