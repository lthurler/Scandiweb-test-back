<?php

namespace Model;


use Service\DAO;
use Model\Product;


class Dvd extends Product
{
    private $size;
    protected $product_id;
        
    
    public function __construct($sku ,$name, $price, $product_type, $size) {

        parent::__construct($sku ,$name, $price, $product_type);
        $this->setSize($size);   
    }

    public function getSize() {
        return $this->size;
    }
    
    public function setSize($size) {
        $this->size = $size;
    }
    
    public function getProduct_id()
    {
        return $this->product_id;
    }
    
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }
    
    public function add() {

        parent::add();

        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $this->setProduct_id($dao->lastInsertId());
            $sql = "INSERT INTO dvd (product_id, size) VALUES (:product_id, :size)"; 
            
            $stman = $conn->prepare($sql);
            $stman->bindParam(':product_id', $this->getProduct_id());
            $stman->bindParam(':size', $this->getSize());
            $stman->execute();

        } catch (Exception $e)
        {
            throw new Exception("error registering the product" . $e->getmessage());
        }
    }
}
