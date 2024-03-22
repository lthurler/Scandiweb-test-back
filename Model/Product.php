<?php

namespace Model;

use Service\DAO;
use PDOException;
use Exception;
use ReflectionClass;


abstract class Product
{

    protected $sku, $name, $price, $product_type;
    

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

    public function post($product)
    {
        $dao = new DAO;

        try {            
            $conn = $dao->connect();
            $sql = "INSERT INTO product (sku, name, price, product_type)
                    VALUES (:sku, :name, :price, :product_type)";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $product->getSku());
            $stman->bindValue(":name", $product->getName());
            $stman->bindValue(":price", $product->getPrice());
            $stman->bindValue(":product_type", $product->getProductType());            
            $stman->execute();           

        } catch (Exception $e) {
            throw new Exception("error registering the product: " . $e->getmessage());

        } finally {
            $dao->close();
        }        
    }
    
    abstract protected function getAttributes();

    public static function get()
    {
        $dao = new DAO;
        
        $subclasses = self::getSubclasses();

        try {            
            $conn = $dao->connect();            

            $attributes = [];

            foreach ($subclasses as $subclass)
            {
                $reflectionClass = new ReflectionClass($subclass);
                $classInstance = $reflectionClass->newInstanceWithoutConstructor();
                $attributes[] = $classInstance->getAttributes();                
            }

            $sql = "SELECT 
                        product_id,
                        sku, 
                        name, 
                        price, 
                        product_type";

            foreach ($attributes as $attribute) {
                $sql .= ", $attribute";
            }            

            $sql .= " FROM product";

            $stman = $conn->prepare($sql);
            $stman->execute();
            $response = $stman->fetchAll();            

            return $response;

        } catch (PDOException $pdoe) {
            throw new Exception("Error listing all products: " . $pdoe->getMessage());

        } catch (Exception $e) {
            throw new Exception("Error listing all products: " . $e->getMessage());

        } finally {
            $dao->close();
        }
    }

    protected static function getSubclasses()
    {
        $classPath = DIR_APP . DS . 'Model' . DS . '*.php';
        $files = glob($classPath);
        $subclasses = [];

        foreach ($files as $file) {            
            $className = pathinfo($file, PATHINFO_FILENAME);
            $classNamespace = 'Model\\' . $className;
            
            if ($className !== 'Product' && is_subclass_of($classNamespace, 'Model\Product')) {
                $subclasses[] = $classNamespace;
            }
        }

        return $subclasses;
    }    

    public static function delete($body)
    {
        $dao = new DAO;

        try {            
            $conn = $dao->connect();
            $ids = implode(',', array_fill(0, count($body['product_id']), '?'));
            $sql = "DELETE FROM product WHERE product_id IN ($ids)";

            $stman = $conn->prepare($sql);
            $stman->execute($body['product_id']);
            $response = ['Product Deleted'];

            return $response;            

        } catch (PDOException $pdoe) {            
            throw new Exception("Error executing command on database! " . $pdoe->getMessage());                   

        } catch (Exception $e) {
            throw new Exception("Error deleting products " . $e->getMessage());
            
        } finally {
            $dao->close();
        }        
    }
}