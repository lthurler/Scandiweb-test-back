<?php

namespace Model;


use Service\DAO;
use Model\Product;


class Book extends Product
{
    private $weight;
         

    public function __construct($body) {

        $this->setSku($body['sku']);
        $this->setName($body['name']);
        $this->setPrice($body['price']);
        $this->setProductType($body['product_type']);
        $this->setWeight($body['weight']);   
    }

    public function getWeight() {
        return $this->weight;
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
    
    public function add($book) {       
        
        try{
            $dao = new DAO;
            $conn = $dao->connect();            
            $sql = "INSERT INTO product (sku, name, price, product_type, weight)
                    VALUES (:sku, :name, :price, :product_type, :weight)";            
            
            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $book->getSku());
            $stman->bindValue(":name", $book->getName());
            $stman->bindValue(":price", $book->getPrice());
            $stman->bindValue(":product_type", $book->getProductType());           
            $stman->bindValue(':weight', $book->getWeight());
            $stman->execute();           
            
        } catch (Exception $e) {
            throw new Exception ("error registering the product" . $e->getmessage());
        }
    }
}
