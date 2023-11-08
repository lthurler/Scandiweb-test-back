<?php

namespace Service;

use Util\Json;
use Model\Product;
use Model\ProductFactory;
use InvalidArgumentException;


class ProductService
{
    private array $request, $dataRequest;    


    public function getDataRequest()
    {
        return $this->dataRequest;
    }

    public function setDataRequest($dataRequest)
    {
        $this->dataRequest = $dataRequest;        
    }    

    public function setRequest($request)
    {
        $this->request = $request;        
    }

    public function __construct($request)
    {
        $this->setRequest($request);        
    }

    public function handleRequest()
    {
        if (
            in_array($this->request['route'], ['product'], true) &&
            in_array($this->request['resource'], ['post', 'get', 'delete'], true) &&
            in_array($this->request['method'], ['GET', 'POST', 'PATCH'], true)
        ) {

            return $this->bodyRequest();

        } else {
            
            throw new InvalidArgumentException('Route not allowed!');
        }
    }

    private function bodyRequest()
    {
        if ($this->request['method'] !== 'GET') {

            $this->setDataRequest(Json::handleJsonRequestBody());
            return $this->bodyValidade($this->getDataRequest());            

        } else {

            return Product::get();                         
        }
    }

    private function bodyValidade($dataRequest)
    {
        $fields = ['product_id', 'sku', 'name', 'price', 'product_type', 'height', 'width', 'length', 'size', 'weight'];
        $compare = array_diff_key($dataRequest, array_flip($fields));

        if (empty($compare)) {

            $method = strtolower($this->request['method']);
            $body = $this->getDataRequest();

            return $this->$method($body);

        } else {

            throw new InvalidArgumentException('Invalid data');
        }               
    }

    public function post($body)
    {
        return ProductFactory::productSave($body);        
    }

    private function patch($body)
    {
        return Product::delete($body);       
    }
}