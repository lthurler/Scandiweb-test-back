<?php

namespace Service;

use Validator\RequestValidator;
use Model\Product;
use Model\Book;
use Model\Dvd;
use Model\Furniture;

class ProductService
{
    private $method;
    private array $body;

    
    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
   
    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function __construct($method) {
        $this->setMethod($method);
        $this->body = array();
    }


    public function handleMethods($method, $body) {
        return $this->$method($body);
    }

    private function post($body) {

        $className = ucfirst($body['product_type']);
        // var_dump($className);exit;
        $class = new $className($body);
        $class->add();
    }

    private function get() {

        $return = Product::getAll();
        $this->setBody($return);            
        return $return;
    }

    private function update($body) {

        return Product::delete($body);
    }    
}
