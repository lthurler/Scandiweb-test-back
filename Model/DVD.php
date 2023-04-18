<?php

namespace Model;


use Service\DAO;
use Model\Product;


class DVD extends Product
{
    private $size;
            
    
    public function __construct($body) {

        $this->setSku($body['sku']);
        $this->setName($body['name']);
        $this->setPrice($body['price']);
        $this->setProductType($body['product_type']);
        $this->setSize($body['size']);   
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }    
    
    public function getSku() {
        return $this->sku;
    }
    
    public function setSku($sku) {
        $this->sku = $sku;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }    
    
    public function getPrice() {
        return $this->price;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }    
    
    public function getProductType() {
        return $this->product_type;
    }
    
    public function setProductType($product_type) {
        $this->product_type = $product_type;
    }

    public function getSize() {
        return $this->size;
    }
    
    public function setSize($size) {
        $this->size = $size;
    }    
    
    public function add() {        

        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type, weight, size)
                    VALUES (:sku, :name, :price, :product_type, :weight, :size)"; 
            
            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $dvd->getSku());
            $stman->bindValue(":name", $dvd->getName());
            $stman->bindValue(":price", $dvd->getPrice());
            $stman->bindValue(":product_type", $dvd->getProductType());
            $stman->bindValue(':size', $dvd->getSize());
            $stman->execute();

        } catch (Exception $e) {
            throw new Exception("error registering the product" . $e->getmessage());
        }
    }
}
