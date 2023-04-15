<?php

namespace Model;


use Service\DAO;
use Model\Product;


class Book extends Product
{
    private $weight;
    protected $product_id;
       

    public function __construct($sku ,$name, $price, $product_type, $weight) {

        parent::__construct($sku ,$name, $price, $product_type);
        $this->setWeight($weight);   
    }

    public function getWeight() {
        return $this->weight;
    }
    
    public function setWeight($weight) {
        $this->weight = $weight;
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
        
        try{
            $dao = new DAO;
            $conn = $dao->connect();
            $this->setProduct_id($dao->lastInsertId());
            $sql = "INSERT INTO book (product_id, weight)
            VALUES (:product_id, :weight)";
            
            $stman = $conn->prepare($sql);
            $stman->bindParam(':product_id',$this->getProduct_id());
            $stman->bindParam(':weight', $this->getWeight());
            $stman->execute();
            
        } catch (Exception $e)
        {
            throw new Exception ("error registering the product" . $e->getmessage());
        }
    }
}
