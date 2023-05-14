<?php

namespace Service;

use Validator\RequestValidator;
use Model\Product;
use Model\Book;
use Model\DVD;
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

    public function post($body) {
        
        $classSave = strtolower($body['product_type'] . 'Add');
        return $this->$classSave($body);
    }

    public function bookAdd($body) {

        $book = new Book($body);                
        $book->add($book);
        $return = ['Product saved'];        
        return $return;
    }

    private function dvdAdd($body) {

        $dvd = new DVD($body);
        $dvd->add($dvd);
        $return = ['Product saved'];        
        return $return;
    }

    private function furnitureAdd($body) {

        $furniture = new Furniture($body);
        $furniture->add($furniture);
        $return = ['Product saved'];        
        return $return;
    }

    private function get() {

        $return = Product::getAll();
        $this->setBody($return);            
        return $return;
    }

    private function patch($body) {

        Product::delete($body);
        $return = ['Product deleted'];        
        return $return;
    }    
}
