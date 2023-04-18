<?php

namespace Validator;


use Util\Json;
use Util\GenericConstants;
use Service\ProductService;
use InvalidArgumentException;


class RequestValidator
{

    private array $request;
    private array $dataRequest;    


    public function getDataRequest()
    {
        return $this->dataRequest;
    }

    public function setDataRequest($dataRequest)
    {
        $this->dataRequest = $dataRequest;
        return $this;
    }
    
    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function __construct($request) {

        $this->setRequest($request);
        $this->dataRequest = array();
    }
    
    public function handleRequest() {

        if (in_array($this->request['route'], GenericConstants::ROUTES, true) &&
            in_array($this->request['resource'], GenericConstants::RESOURCES, true) &&
            in_array($this->request['method'], GenericConstants::METHODS, true)) {

            return $this->bodyRequest();
                
        } else {

            throw new InvalidArgumentException(GenericConstants::ERROR_MSG_ROUTE);
        }        

        return $return;
    }

    private function bodyRequest() {

        if ($this->request['method']  !== 'GET') {

            $this->setDataRequest(Json::handleJsonRequestBody());
            $return = $this->bodyValidade($this->getDataRequest());

            return $return;

        } else {

            $method = 'get';
            $productService = new ProductService($method);
            $productService->handleMethods($method ,$productService->getBody());
            $return = $productService->getBody();
            return $return;
            
        }        
    }

    private function bodyValidade($dataRequest) {

        $fields = ['product_id', 'sku', 'name', 'price', 'product_type', 'height', 'width', 'length', 'size', 'weight'];
        $compare = array_diff_key($dataRequest, array_flip($fields));
        
        if (empty($compare)) {

            $method = strtolower($this->request['method']);
            $body = $this->dataRequest;           

        } else {

            throw new InvalidArgumentException('Invalid data');
        }

        $productService = new ProductService($method);
        $productService->setBody($body);
        $return = $productService->handleMethods($method, $body);
        return $return;        
    }     
}
