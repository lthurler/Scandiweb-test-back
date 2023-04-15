<?php

namespace Model;

use Service\DAO;


abstract class Product 
{

    protected $product_id;
    protected $sku;
    protected $name;
    protected $price;
    protected $product_type;
    protected $active = true;
    

    protected function __construct($sku, $name, $price, $product_type) {

        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->setProductType($product_type);
    }

    public function getProduct_id() {
        return $this->product_id;
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
    
    public function add() {

        try {
            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "INSERT INTO products (sku, name, price, product_type)
                    VALUES (:sku, :name, :price, :product_type)";
            
            $stman = $conn->prepare($sql);
            $stman->bindParam(":sku", $this->sku);
            $stman->bindParam(":name", $this->name);
            $stman->bindParam(":price", $this->price);
            $stman->bindParam(":product_type", $this->product_type);
            $stman->execute();

        } catch (Exception $e)
        {
            throw new Exception("error registering the product" . $e->getMessage());
        }
    }

    public static function getAll() {

        try {

            $dao = new DAO;
            $conn = $dao->connect();
            $sql = "SELECT 
                        p.product_id, 
                        p.sku, 
                        p.name, 
                        p.price, 
                        p.product_type,
                        d.size AS Size,
                        b.weight AS Weight,
                        CONCAT(f.height, ' x ', f.width, ' x ', f.length) END AS Dimension
                        FROM product p
                    LEFT JOIN dvd d ON p.product_id = d.product_id
                    LEFT JOIN book b ON p.product_id = b.product_id
                    LEFT JOIN furniture f ON p.product_id = f.product_id
                    WHERE p.active = true;";                         

            $stman = $conn->prepare($sql);
            $stman->execute();
            $return = $stman->fetchAll();

            return $return;

        } catch (PDOException $pdoe) {
            throw new Exception("Error executing command on database!" . $pdoe->getMessage());

        } catch (JsonException $jsone) {
            throw new Exception("Error while assembling the json" . $jsone->getMessage());

        } catch (Exception $e) {
            throw new Exception("Error listing all users" . $e->getMessage());
        }
    }

    public static function delete($body) {

        try {
            $dao = new DAO;
            $conn = $dao->connect(); 
            
            $sql = "UPDATE product set active = false where product_id IN (";
            $productIds = [];
            
            foreach ($body as $ids) {
                $productIds[] = $ids->getProduct_id();
                $sql .= "?,";
            }
            
            $sql = rtrim($sql, ",");
            $sql .= ")";
            
            $stman = $conn->prepare($sql);
            $stman->execute($productIds);

        } catch (Exception $e) {
            throw new Exception("Error deleting products" . $e->getMessage());
        }
    }    
}
