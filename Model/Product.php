<?php

namespace Model;

use Service\DAO;
use PDOException;
use Exception;


abstract class Product
{

    protected $sku, $name, $price, $product_type, $active = true;
    

    public function __construct($body)
    {
        $this->setSku($body['sku']);
        $this->setName($body['name']);
        $this->setPrice($body['price']);
        $this->setProductType($body['product_type']);
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
        $this->name =$name;
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

    abstract public function post($product);


    public static function get()
    {
        try {

            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "SELECT 
                        product_id,
                        sku, 
                        name, 
                        price, 
                        product_type,
                        size,
                        weight,
                        CONCAT(height, 'x', width, 'x', length) AS dimension,
                        active                       
                    FROM product;";

            $stman = $conn->prepare($sql);
            $stman->execute();
            $response = $stman->fetchAll();

            return $response;

        } catch (Exception $e) {
            throw new Exception("Error listing all users " . $e->getMessage());
        }
    }

    public static function delete($body)
    {
        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $ids = implode(',', array_fill(0, count($body['product_id']), '?'));
            $sql = "UPDATE product SET active = false WHERE product_id IN ($ids)";
            $stman = $conn->prepare($sql);
            $stman->execute($body['product_id']);            

        } catch (PDOException $pdoe) {
            throw new Exception("Error executing command on database! " . $pdoe->getMessage());        

        } catch (Exception $e) {
            throw new Exception("Error deleting products " . $e->getMessage());
        }
    }
}