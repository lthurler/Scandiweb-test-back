<?php

namespace Model;


use Exception;
use Service\DAO;
use Model\Product;


class Book extends Product
{
    private $weight;


    public function __construct($body)
    {
        parent::__construct($body);
        $this->setWeight($body['weight']);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }    

    public function post($product)
    {
        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type, weight)
                    VALUES (:sku, :name, :price, :product_type, :weight)";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $product->getSku());
            $stman->bindValue(":name", $product->getName());
            $stman->bindValue(":price", $product->getPrice());
            $stman->bindValue(":product_type", $product->getProductType());
            $stman->bindValue(':weight', $product->getWeight());
            $stman->execute();

        } catch (Exception $e) {
            throw new Exception("error registering the product: " . $e->getmessage());
        }
    }
}