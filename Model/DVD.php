<?php

namespace Model;

use Exception;
use Service\DAO;
use PDOException;
use Model\Product;


class Dvd extends Product
{
    private $size;


    public function __construct($body)
    {
        parent::__construct($body);
        $this->setSize($body['size']);
    }    

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function post($product)
    {
        $dao = new DAO;

        try {
            parent::post($product);
            
            $conn = $dao->connect();           
            $sql = "UPDATE product SET size = :size WHERE sku = :sku";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $this->getSku());            
            $stman->bindValue(':size', $this->getsize());
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
        return 'size';
    }
}