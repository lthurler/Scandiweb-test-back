<?php

namespace Model;

use Exception;
use Service\DAO;
use PDOException;
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
        $dao = new DAO;

        try {
            parent::post($product);
            
            $conn = $dao->connect();           
            $sql = "UPDATE product SET weight = :weight WHERE sku = :sku";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $this->getSku());            
            $stman->bindValue(':weight', $this->getWeight());
            $stman->execute();
            $response = ['Product added on database'];

            return $response;
        
        } catch (PDOException $pdoe) {            
            throw new Exception("Error executing command on database! " . $pdoe->getMessage());        

        } catch (Exception $e) {
            throw new Exception("error registering the product: " . $e->getmessage());

        } finally {
            $dao->close();
        }
    }

    protected function getAttributes()
    {
        return 'weight';
    }
}