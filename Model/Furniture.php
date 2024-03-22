<?php

namespace Model;

use Exception;
use Service\DAO;
use PDOException;
use Model\Product;


class Furniture extends Product
{
    private $height, $width, $length;
    

    public function __construct($body)
    {
        parent::__construct($body);
        $this->setHeight($body['height']);
        $this->setWidth($body['width']);
        $this->setLength($body['length']);
    }    

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function post($product)
    {
        $dao = new DAO;

        try {
            parent::post($product);
            
            $conn = $dao->connect();           
            $sql = "UPDATE product SET height = :height, width = :width, length = :length WHERE sku = :sku";

            $stman = $conn->prepare($sql);
            $stman->bindValue(":sku", $this->getSku());            
            $stman->bindValue(':height', $this->getHeight());
            $stman->bindValue(':width', $this->getWidth());
            $stman->bindValue(':length', $this->getLength());
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
        return "CONCAT(height, 'x', width, 'x', length) AS dimension";
    }
}