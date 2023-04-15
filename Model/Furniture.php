<?php

namespace Model;


use Service\DAO;
use Model\Product;


class Furniture extends Product
{
    private $height;
    private $width;
    private $length;
    protected $product_id;
    
    public function __construct($sku ,$name, $price, $product_type, $height ,$width ,$length) {

        parent::__construct($sku ,$name, $price, $product_type);
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setLength($length);    
    }

    public function getHeight() {
        return $this->height;
    }
    
    public function setHeight($height) {
        $this->height = $height;
    }    
    
    public function getWidth() {
        return $this->width;
    }
    
    public function setWidth($width) {
        $this->width = $width;
    }    
    
    public function getLength() {
        return $this->length;
    }
    
    public function setLength($length) {
        $this->length = $length;
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
            $sql = "INSERT INTO furniture (product_id, height, width, length)
                    VALUES (:product_id, :height, :width, :length)";
            
            $stman = $conn->prepare($sql);
            $stman->bindParam(':product_id', $this->getProduct_id());
            $stman->bindParam(':height', $this->getHeight());
            $stman->bindParam(':width', $this->getWidth());
            $stman->bindParam(':length', $this->getLength());
            $stman->execute();

        } catch (Exception $e)
        {
            throw new Exception("error registering the product" . $e->getmessage());
        }
    }    
}
